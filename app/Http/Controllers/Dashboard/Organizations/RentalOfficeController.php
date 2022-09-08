<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRentalOfficeRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\RentalOffice;
use Illuminate\Support\Facades\File;

class RentalOfficeController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(RentalOffice $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-rental_offices'])->only('index');
        $this->middleware(['permission:create-rental_offices'])->only('create');
        $this->middleware(['permission:update-rental_offices'])->only('edit');
        $this->middleware(['permission:delete-rental_offices'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $rental_offices = RentalOffice::latest('id')->get();
            return view('admin.organizations.rental_offices.index', compact('rental_offices'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            return view('admin.organizations.rental_offices.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminRentalOfficeRequest $request)
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

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            if (!$request->has('delivery_active'))
                $request->request->add(['delivery_active' => 0]);
            else
                $request->request->add(['delivery_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'email', 'password', 'password_confirmation']);

            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $rental_office = RentalOffice::create($request_data);

            $rental_office->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('rental-offices.index')->with(['success' => __('message.created_successfully')]);
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
            $rental_office = $this->getModelById($id);
            $users = $rental_office->organization_users()->latest('id')->get();
            return view('admin.organizations.rental_offices.show', compact('rental_office', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $rental_office = $this->getModelById($id);
            $users = $rental_office->organization_users()->get();
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.organizations.rental_offices.edit', compact('rental_office', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminRentalOfficeRequest $request, $id)
    {
        try {
            $rental_office = RentalOffice::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            if (!$request->has('delivery_active'))
                $request->request->add(['delivery_active' => 0]);
            else
                $request->request->add(['delivery_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation', 'organization_user_id']);

            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $rental_office->getRawOriginal('logo'))) {
                    File::delete($image_path . $rental_office->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }
            $user = $rental_office->organization_users()->find($request->organization_user_id);
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
            $rental_office->update($request_data);
            return redirect()->route('rental-offices.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $rental_office = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $rental_office->getRawOriginal('logo'))) {
                File::delete($image_path . $rental_office->getRawOriginal('logo'));
            }
            $rental_office->delete();
            return redirect()->route('rental-offices.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $rental_office = $this->model->find($org_id);
            $user = $rental_office->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $rental_office = $this->model->find($org_id);
            $users = $rental_office->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
