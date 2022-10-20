<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTrainerRequest;
use App\Http\Requests\DrivingTrainerRequest;
use App\Models\Area;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\DrivingTrainer;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class DrivingTrainersController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;
    private $brand;
    private $carModel;
    private $carClass;
    private $categories;

    public function __construct(DrivingTrainer $model, Country $country, City $city, Area $area, Brand $brand, CarModel $carModel, CarClass $carClass, Category $category)
    {
        $this->middleware(['permission:read-driving_trainers'])->only('index');
        $this->middleware(['permission:create-driving_trainers'])->only('create');
        $this->middleware(['permission:update-driving_trainers'])->only('edit');
        $this->middleware(['permission:delete-driving_trainers'])->only('delete');

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
            $trainers = $this->model->latest('id')->get();
            return view('admin.organizations.driving_trainers.index', compact('trainers'));
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
            return view('admin.organizations.driving_trainers.create', compact('categories', 'countries', 'brands', 'car_classes'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminTrainerRequest $request)
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

            $request_data = $request->except(['_token', 'profile_picture', 'trainer_vehicle', 'user_name', 'email', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $hour_price = $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
            $request_data['hour_price'] = $hour_price;

            $request_data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));
            if ($request->has('profile_picture')) {
                $image = $request->profile_picture->store('trainers/profile_pictures');
                $request_data['profile_picture'] = $image;
            }
            $trainer = $this->model->create($request_data);

            if ($request->has('trainer_vehicle')) {
                $trainer->uploadImage();
            }

            createMasterOrgUser($trainer);

            return redirect()->route('trainers.index')->with(['success' => __('message.created_successfully')]);
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
            $trainer = $this->model->with('brand', 'car_model', 'file')->find($id);
            $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
            return view('admin.organizations.driving_trainers.show', compact('trainer', 'hour_price'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $trainer = $this->getModelById($id);
            $users = $trainer->organization_users()->get();
            $categories = $this->categories->where('section_id', 16)->latest('id')->get();
            $countries = $this->country->latest('id')->get();
            $brands = $this->brand->latest('id')->get();
            $car_classes = $this->carClass->latest('id')->get();
            return view('admin.organizations.driving_trainers.edit', compact('trainer', 'users', 'categories', 'countries', 'brands', 'car_classes'));

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminTrainerRequest $request, $id)
    {
        try {
            $trainer = $this->getModelById($id);
            if (!$request->has('active')) {
                $request->request->add(['active' => 0]);
            } else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'profile_picture', 'trainer_vehicle', 'user_name', 'email', 'password', 'password_confirmation', 'organization_user_id']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $request_data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));

            if ($request->has('profile_picture')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $trainer->getRawOriginal('profile_picture'))) {
                    File::delete($image_path . $trainer->getRawOriginal('profile_picture'));
                }

                $image = $request->profile_picture->store('trainers/profile_pictures');
                $request_data['profile_picture'] = $image;
            }

            if ($request->hasFile('trainer_vehicle')) {
                $trainer->updateImage();
            }

            $user = $trainer->organization_users()->find($request->organization_user_id);
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

            $trainer->update($request_data);
            return redirect()->route('trainers.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $trainer = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if ($trainer->profile_picture) {
                if (File::exists($image_path . $trainer->getRawOriginal('profile_picture'))) {
                    File::delete($image_path . $trainer->getRawOriginal('profile_picture'));
                }
            }
            $user = $trainer->organization_users();
            $user->delete();
            $trainer->deleteImage();
            $trainer->delete();
            return redirect()->route('trainers.index')->with(['success' => __('message.deleted_successfully')]);
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
