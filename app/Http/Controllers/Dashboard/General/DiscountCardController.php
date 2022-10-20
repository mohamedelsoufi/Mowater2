<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountCardRequest;
use App\Models\DiscountCard;
use App\Models\DiscountCardOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DiscountCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-discount_cards'])->only('index');
        $this->middleware(['permission:create-discount_cards'])->only('create');
        $this->middleware(['permission:update-discount_cards'])->only('edit');
        $this->middleware(['permission:delete-discount_cards'])->only('delete');
        $this->middleware(['permission:read-org-discount_cards'])->only('getDiscountCardOrg');
        $this->middleware(['permission:delete-org-discount_cards'])->only('deleteDiscountCardOrg');
    }

    public function index()
    {
        try {
            $discount_cards = DiscountCard::latest('id')->get();
            return view('admin.general.discount_cards.index', compact('discount_cards'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function create()
    {
        return view('admin.general.discount_cards.create');
    }

    public function store(DiscountCardRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'image']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('image')) {
                $image = $request->image->store('discount_cards');
                $request_data['image'] = $image;
            }
            DiscountCard::create($request_data);
            return redirect()->route('discount-cards.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $discount_card = DiscountCard::find($id);
            return view('admin.general.discount_cards.show', compact('discount_card'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $discount_card = DiscountCard::find($id);
            return view('admin.general.discount_cards.edit', compact('discount_card'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(DiscountCardRequest $request, $id)
    {
        try {
            $discount_card = DiscountCard::find($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'image']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('image')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $discount_card->getRawOriginal('image'))) {
                    File::delete($image_path . $discount_card->getRawOriginal('image'));
                }

                $image = $request->image->store('discount_cards');
                $request_data['image'] = $image;
            }
            $discount_card->update($request_data);
            return redirect()->route('discount-cards.index')->with(['success' => __('message.updated_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $discount_card = DiscountCard::find($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $discount_card->getRawOriginal('image'))) {
                File::delete($image_path . $discount_card->getRawOriginal('image'));
            }
            $discount_card->delete();
            return redirect()->route('discount-cards.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getDiscountCardOrg($id)
    {
        try {
            $organizations = DiscountCardOrganization::where('discount_card_id', $id)->get();
            $org_name = [];
            foreach ($organizations as $organization) {
                $model_type = $organization->organizable_type;
                $model_id = $organization->organizable_id;
                $model = new $model_type;
                $get_organization = $model->find($model_id);
                $org_name[] = [
                    'name' => $get_organization->name,
                    'logo' => $get_organization->logo == null ? $get_organization->profile : $get_organization->logo,
                    'active' => $organization->getActive(),
                    'discountCardOrgId' => $organization->id,
                    'created_at' => $organization->created_at,
                    'updated_at' => $organization->updated_at,
                ];
            }
            return view('admin.general.discount_cards.getOrganizations', compact('org_name'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function showDiscountCardOrg($id)
    {
        try {
            $organization = DiscountCardOrganization::find($id);
            $model_type = $organization->organizable_type;
            $model_id = $organization->organizable_id;
            $model = new $model_type;
            $get_organization = $model->find($model_id);
            $org = [
                'name' => $get_organization->name,
                'logo' => $get_organization->logo == null ? $get_organization->profile : $get_organization->logo,
                'active' => $organization->active,
                'discountCardOrgId' => $organization->id,
                'created_at' => $organization->created_at,
                'updated_at' => $organization->updated_at,
            ];
            return view('admin.general.discount_cards.showOrganization', compact('org','id'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function deleteDiscountCardOrg($id)
    {
        try {
            $organization = DiscountCardOrganization::find($id);
            $organization->delete();
            return redirect()->back()->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function updateDiscountCardOrg(Request $request, $id)
    {
        try {
            $organization = DiscountCardOrganization::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token']);
            $organization->update($request_data);
            return redirect()->back()->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
