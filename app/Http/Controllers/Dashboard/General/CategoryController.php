<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\Section;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-categories'])->only('index');
        $this->middleware(['permission:create-categories'])->only('create');
        $this->middleware(['permission:update-categories'])->only('edit');
        $this->middleware(['permission:delete-categories'])->only('delete');
    }

    public function index()
    {
        try {
            $categories = Category::latest()->get();
            return view('admin.general.categories.index', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $sections = Section::latest()->get();
            return view('admin.general.categories.create', compact('sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            Category::create($request_data);
            return redirect()->route('categories.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong') . $e->getMessage()]);
        }
    }


    public function show($id)
    {
        try {
            $category = Category::find($id);
            return view('admin.general.categories.show', compact('category'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong') . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::find($id);
            $sections = Section::latest()->get();
            return view('admin.general.categories.edit', compact('category', 'sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong') . $e->getMessage()]);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $category->update($request_data);
            return redirect()->route('categories.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong') . $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return redirect()->route('categories.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong') . $e->getMessage()]);
        }
    }
}
