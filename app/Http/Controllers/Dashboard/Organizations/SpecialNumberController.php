<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSpecialNumberRequest;
use App\Models\Category;
use App\Models\SpecialNumber;
use App\Models\SpecialNumberOrganization;
use App\Models\SubCategory;
use App\Models\User;

class SpecialNumberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-special_numbers'])->only('index');
        $this->middleware(['permission:create-special_numbers'])->only('create');
        $this->middleware(['permission:update-special_numbers'])->only('edit');
        $this->middleware(['permission:delete-special_numbers'])->only('delete');
    }

    public function index()
    {
        try {
            $special_numbers = SpecialNumber::latest('id')->get();
            $special_number_organizations = SpecialNumberOrganization::latest('id')->get();
            $users = User::latest('id')->get();
            return view('admin.organizations.special_numbers.special_number.index',
                compact('special_numbers', 'special_number_organizations', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        $special_number_organizations = SpecialNumberOrganization::latest('id')->get();
        $categories = Category::where('section_id', 4)->latest('id')->get();
        $categories_id = Category::where('section_id', 4)->pluck('id')->toArray();
        $sub_categories = SubCategory::whereIn('category_id', $categories_id)->get();
        return view('admin.organizations.special_numbers.special_number.create',compact('special_number_organizations', 'categories', 'sub_categories'));
    }


    public function store(AdminSpecialNumberRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('availability'))
                $request->request->add(['availability' => 0]);
            else
                $request->request->add(['availability' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token']);
            SpecialNumber::create($request_data);
            return redirect()->route('special-numbers.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $special_number = SpecialNumber::find($id);
            return view('admin.organizations.special_numbers.special_number.show', compact('special_number'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $special_number = SpecialNumber::find($id);
            $special_number_organizations = SpecialNumberOrganization::latest('id')->get();
            $categories = Category::where('section_id', 4)->latest('id')->get();
            $categories_id = Category::where('section_id', 4)->pluck('id')->toArray();
            $sub_categories = SubCategory::whereIn('category_id', $categories_id)->get();
            return view('admin.organizations.special_numbers.special_number.edit',
                compact('special_number', 'special_number_organizations', 'categories', 'sub_categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminSpecialNumberRequest $request, $id)
    {
        try {
            $special_number = SpecialNumber::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('availability'))
                $request->request->add(['availability' => 0]);
            else
                $request->request->add(['availability' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token']);
            $special_number->update($request_data);
            return redirect()->route('special-numbers.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $special_number = SpecialNumber::find($id);
            $special_number->delete();
            return redirect()->route('special-numbers.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getCategories($id)
    {
        try {
            $category = Category::find($id);
            $category->makeVisible('name_en', 'name_ar');
            $data = compact('category');
            return response()->json(['status' => true, 'data' => $data]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getSubCategories($id)
    {
        try {
            $sub_categories = SubCategory::where('category_id',$id)->get();
            $sub_categories->makeVisible('name_en', 'name_ar');
            $data = compact('sub_categories');
            return response()->json(['status' => true, 'data' => $data]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
