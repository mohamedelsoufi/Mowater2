<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-sub_categories'])->only('index');
        $this->middleware(['permission:create-sub_categories'])->only('create');
        $this->middleware(['permission:update-sub_categories'])->only('edit');
        $this->middleware(['permission:delete-sub_categories'])->only('delete');
    }

    public function index()
    {
        try {
            $sub_categories = SubCategory::latest('id')->get();
            return view('admin.general.sub-categories.index', compact('sub_categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function create()
    {
        try {
            $categories = Category::latest('id')->get();
            return view('admin.general.sub-categories.create', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(SubCategoryRequest $request)
    {
        try {
            SubCategory::create($request->except(['_token']));
            return redirect()->route('sub-categories.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        try {
            $sub_category = SubCategory::find($id);
            return view('admin.general.sub-categories.show', compact('sub_category'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function edit($id)
    {
        try {
            $sub_category = SubCategory::find($id);
            $categories = Category::latest('id')->get();
            return view('admin.general.sub-categories.edit', compact('sub_category', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(SubCategoryRequest $request, $id)
    {
        try {
            $sub_category = SubCategory::find($id);
            $sub_category->update($request->except(['_token']));
            return redirect()->route('sub-categories.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $sub_category = SubCategory::find($id);
            $sub_category->delete();
            return redirect()->route('sub-categories.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
