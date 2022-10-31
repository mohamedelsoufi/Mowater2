<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAppUserRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AppUserController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(User $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-app_users'])->only('index');
        $this->middleware(['permission:create-app_users'])->only('create');
        $this->middleware(['permission:update-app_users'])->only('edit');
        $this->middleware(['permission:delete-app_users'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $users = $this->model->latest('id')->get();
            return view('admin.general.AppUsers.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

//    public function create()
//    {
//        //
//    }
//
//    public function store(Request $request)
//    {
//        //
//    }

    private function getModelById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function show($id)
    {
        try {
            $user = $this->getModelById($id);
            return view('admin.general.AppUsers.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->getModelById($id);
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.general.AppUsers.edit', compact('user', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminAppUserRequest $request, $id)
    {
        try {
            $user = $this->getModelById($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('is_verified'))
                $request->request->add(['is_verified' => 0]);
            else
                $request->request->add(['is_verified' => 1]);

            $request_data = $request->except(['_token', 'profile_image', 'password_confirmation']);
            $request_data['created_by'] = auth()->user()->email;
            if ($request->has('profile_image')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $user->getRawOriginal('profile_image'))) {
                    File::delete($image_path . $user->getRawOriginal('profile_image'));
                }

                $image = $request->profile_image->store('api_profile_images');
                $request_data['profile_image'] = $image;
            }
            $user->update($request_data);
            return redirect()->route('app-users.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->getModelById($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $user->getRawOriginal('profile_image'))) {
                File::delete($image_path . $user->getRawOriginal('profile_image'));
            }
            $user->delete();
            return redirect()->route('app-users.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
