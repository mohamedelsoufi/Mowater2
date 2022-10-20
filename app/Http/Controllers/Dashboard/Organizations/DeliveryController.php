<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminDeliveryRequest;
use App\Http\Requests\DeliveryRequest;
use App\Models\Area;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryMan;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DeliveryController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;
    private $brand;
    private $carModel;
    private $carClass;
    private $categories;

    public function __construct(DeliveryMan $model, Country $country, City $city, Area $area, Brand $brand, CarModel $carModel, CarClass $carClass, Category $category)
    {
        $this->middleware(['permission:read-delivery'])->only('index');
        $this->middleware(['permission:create-delivery'])->only('create');
        $this->middleware(['permission:update-delivery'])->only('edit');
        $this->middleware(['permission:delete-delivery'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
        $this->brand = $brand;
        $this->carModel = $carModel;
        $this->carClass = $carClass;
        $this->categories = $category;
    }

    public function index()
    {
        try {
            $delivery_men = $this->model->latest('id')->get();
            return view('admin.organizations.delivery.index', compact('delivery_men'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $categories = $this->categories->where('section_id', 16)->latest('id')->get();
            $countries = $this->country->latest('id')->get();
            $brands = $this->brand->latest('id')->get();
            $car_classes = $this->carClass->latest('id')->get();
            return view('admin.organizations.delivery.create', compact('categories', 'countries', 'brands', 'car_classes'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminDeliveryRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'profile_picture', 'file_url', 'category_id', 'user_name', 'email', 'password', 'password_confirmation', 'license']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $request_data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));

            if ($request->has('profile_picture')) {
                $image = $request->profile_picture->store('delivery');
                $request_data['profile_picture'] = $image;
            }

            $delivery = $this->model->create($request_data);
            if ($request->has('file_url') || $request->has('license')) {
                $delivery->uploadImage();
            }

            if ($request->has('category_id')) {
                $delivery->categories()->attach($request->category_id);
            }
            if ($delivery) {
                createMasterOrgUser($delivery);
                return redirect()->route('delivery.index')->with(['success' => __('message.created_successfully')]);
            }
            return redirect()->route('delivery.index')->with(['error' => __('message.something_wrong')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    private function getModelById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function show($id)
    {
        try {
            $delivery = $this->getModelById($id);
            $reservation_cost = Section::where('ref_name', 'DeliveryMan')->first()->reservation_cost;
            $users = $delivery->organization_users()->get();
            return view('admin.organizations.delivery.show', compact('delivery', 'users', 'reservation_cost'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $delivery = $this->getModelById($id);
            $users = $delivery->organization_users()->get();
            $categories = $this->categories->where('section_id', 16)->latest('id')->get();
            $countries = $this->country->latest('id')->get();
            $brands = $this->brand->latest('id')->get();
            $car_classes = $this->carClass->latest('id')->get();
            return view('admin.organizations.delivery.edit', compact('delivery', 'users', 'categories', 'countries', 'brands', 'car_classes'));

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminDeliveryRequest $request)
    {
        try {
            $delivery = $this->model->find($request->id);
            if (!$request->has('active')) {
                $request->request->add(['active' => 0]);
            } else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'profile_picture', 'file_url', 'category_id', 'user_name', 'email', 'password', 'password_confirmation', 'organization_user_id', 'license']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $request_data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));

            if ($request->has('category_id')) {
                $delivery->categories()->sync($request->category_id);
            }

            if ($request->has('profile_picture')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $delivery->getRawOriginal('profile_picture'))) {
                    File::delete($image_path . $delivery->getRawOriginal('profile_picture'));
                }

                $image = $request->profile_picture->store('delivery');
                $request_data['profile_picture'] = $image;
            }

            $user = $delivery->organization_users()->find($request->organization_user_id);
            if ($request->user_name) {
                $user->update([
                    'user_name' => $request->user_name,
                ]);
            }
            if ($request->password) {
                $user->update([
                    'password' => $request->password,
                ]);
            }
            $delivery->update($request_data);

            if ($request->hasFile('file_url') || $request->hasFile('license')) {
                $delivery->updateImage();
            }
            return redirect()->route('delivery.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $delivery = $this->getModelById($id);
            $image_path = public_path('uploads/');
            if ($delivery->profile_picture) {
                if (File::exists($image_path . $delivery->getRawOriginal('profile_picture'))) {
                    File::delete($image_path . $delivery->getRawOriginal('profile_picture'));
                }
            }
            $user = $delivery->organization_users();
            $user->delete();
            $delivery->deleteImages();

            $delivery->delete();
            return redirect()->route('delivery.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $wench = $this->model->find($org_id);
            $user = $wench->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $wench = $this->model->find($org_id);
            $users = $wench->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
