<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAccessoriesStoreRequest;
use App\Models\AccessoriesStore;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AccessoriesStoreController extends Controller
{
    private $model;
    private $city;

    public function __construct(AccessoriesStore $model, City $city)
    {
        $this->middleware(['permission:read-accessories_stores'])->only('index');
        $this->middleware(['permission:create-accessories_stores'])->only('create');
        $this->middleware(['permission:update-accessories_stores'])->only('edit');
        $this->middleware(['permission:delete-accessories_stores'])->only('delete');

        $this->model = $model;
        $this->city = $city;
    }

    public function index()
    {
        try {
            $stores = $this->model->latest('id')->get();
            return view('admin.organizations.auto_service_centers.accessories_stores.index', compact('stores'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.accessories_stores.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminAccessoriesStoreRequest $request)
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
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $store = $this->model->create($request_data);

            createMasterOrgUser($store);
            return redirect()->route('accessories-stores.index')->with(['success' => __('message.created_successfully')]);
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
            $store = $this->getModelById($id);
            $users = $store->organization_users()->get();
            return view('admin.organizations.auto_service_centers.accessories_stores.show', compact('store', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $store = $this->getModelById($id);
            $users = $store->organization_users()->get();
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.accessories_stores.edit', compact('store', 'users', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminAccessoriesStoreRequest $request, $id)
    {
        try {
            $store = $this->getModelById($id);

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
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $store->getRawOriginal('logo'))) {
                    File::delete($image_path . $store->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $store->organization_users()->find($request->organization_user_id);
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

            $store->update($request_data);

            return redirect()->route('accessories-stores.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $store = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $store->getRawOriginal('logo'))) {
                File::delete($image_path . $store->getRawOriginal('logo'));
            }
            $store->delete();
            return redirect()->route('accessories-stores.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $car_showroom = $this->model->find($org_id);
            $user = $car_showroom->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $car_showroom = $this->model->find($org_id);
            $users = $car_showroom->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
