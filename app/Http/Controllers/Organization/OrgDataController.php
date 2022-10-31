<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\OrganizationRequest;
use App\Models\Agency;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class OrgDataController extends Controller
{
    private $branch;
    private $country;

    public function __construct(Branch $branch, Country $country)
    {
        $this->middleware(['HasGeneralData:read'])->only(['index', 'show']);
        $this->middleware(['HasGeneralData:update'])->only('edit');
        $this->middleware(['HasGeneralData:read-org-branch'])->only(['getBranches', 'showBranch']);
        $this->middleware(['HasGeneralData:create-org-branch'])->only('createBranch');
        $this->middleware(['HasGeneralData:update-org-branch'])->only('editBranch');
        $this->branch = $branch;
        $this->country = $country;
    }

    public function index()
    {
        try {
            $record = getModelData();
            return view('organization.generalOrg.index', compact('record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show()
    {
        try {
            $record = getModelData();

            if ($record->files) {
                $record->files;
            }
            if ($record->file) {
                $record->file;
            }
            return view('organization.generalOrg.show', compact('record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();

            if ($record->files) {
                $record->files;
            }
            if ($record->file) {
                $record->file;
            }
            $countries = $this->country->latest('id')->get();
            $brands = Brand::get();

            return view('organization.generalOrg.edit', compact('record', 'countries', 'brands'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(OrganizationRequest $request, $id)
    {
        try {
            $record = getModelData();

            if (!$request->has('available'))
                $request->request->add(['available' => 0]);
            else
                $request->request->add(['available' => 1]);

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_availability' => 1]);

            if (!$request->has('reservation_availability'))
                $request->request->add(['reservation_availability' => 0]);
            else
                $request->request->add(['reservation_availability' => 1]);

            if (!$request->has('delivery_availability'))
                $request->request->add(['delivery_availability' => 0]);
            else
                $request->request->add(['delivery_availability' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'logo', 'fuel_types']);
            if ($request->has('fuel_types')) {
                $request_data['fuel_types'] = implode(",", $request->fuel_types);;
            }
            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $record->getRawOriginal('logo'))) {
                    File::delete($image_path . $record->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }
            if ($request->has('birth_date')) {
                $request_data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));

            }
            if ($request->has('profile_picture')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $record->getRawOriginal('profile_picture'))) {
                    File::delete($image_path . $record->getRawOriginal('profile_picture'));
                }

                $image = $request->profile_picture->store('profile_pictures');
                $request_data['profile_picture'] = $image;
            }
            if ($request->has('image')) {
                $request_data['license_certificate'] = 1;
                $record->updateImage();
            }
            $record->update($request_data);
            return redirect()->route('organization.organizations.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function getBranches()
    {
        try {
            $record = getModelData();
            $branches = $record->branches()->latest('id')->get();
            return view('organization.generalOrg.branches.index', compact('record', 'branches'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function showBranch($id)
    {
        try {
            $record = getModelData();
            $branch = $this->branch->find($id);
            return view('organization.generalOrg.branches.show', compact('record', 'branch'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function createBranch()
    {
        try {
            $record = getModelData();
            $countries = $this->country->get();
            return view('organization.generalOrg.branches.create', compact('record', 'countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function storeBranch(BranchRequest $request)
    {
        try {
            $record = getModelData();
            if (!$request->has('availability'))
                $request->request->add(['availability' => 0]);
            else
                $request->request->add(['availability' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            $request_data = $request->except(['_token', 'user_name', 'email', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('web')->user()->email;

            $branch = $record->branches()->create($request_data);

            createMasterBranchUser($branch);
            return redirect()->route('organization.org.branches.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function editBranch($id)
    {
        try {
            $record = getModelData();
            $branch = $this->branch->find($id);
            $countries = $this->country->get();
            return view('organization.generalOrg.branches.edit', compact('record', 'branch', 'countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function updateBranch(BranchRequest $request, $id)
    {
        try {
            $branch = $this->branch->find($id);

            if (!$request->has('availability'))
                $request->request->add(['availability' => 0]);
            else
                $request->request->add(['availability' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            $request_data = $request->except(['_token', 'user_name', 'password', 'password_confirmation','organization_user_id']);
            $request_data['created_by'] = auth('web')->user()->email;

            $user = $branch->organization_users()->find($request->organization_user_id);
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
            $branch->update($request_data);
            return redirect()->route('organization.org.branches.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function deleteBranch($id)
    {
        try {
            $branch = $this->branch->find($id);
            $user = $branch->organization_users();
            $user->delete();
            $branch->delete();
            return redirect()->route('organization.org.branches.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $branch = $this->branch->find($org_id);
            $user = $branch->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', __('message.something_wrong'));
        }
    }

    public function getUsers($org_id)
    {
        try {
            $branch = $this->branch->find($org_id);
            $users = $branch->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', __('message.something_wrong'));
        }
    }
}
