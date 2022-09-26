<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-colors'])->only('index');
        $this->middleware(['permission:create-colors'])->only('create');
        $this->middleware(['permission:update-colors'])->only('edit');
        $this->middleware(['permission:delete-colors'])->only('delete');
    }

    public function index()
    {
        try {
            $colors = Color::latest()->get();
            return view('admin.general.colors.index', compact('colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        return view('admin.general.colors.create');
    }

    public function store(ColorRequest $request)
    {
        try {
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            Color::create($request_data);
            return redirect()->route('colors.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $color = Color::find($id);
            return view('admin.general.colors.show', compact('color'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $color = Color::find($id);
            return view('admin.general.colors.edit', compact('color'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(ColorRequest $request, $id)
    {
        try {
            $color = Color::find($id);
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $color->update($request_data);
            return redirect()->route('colors.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $color = Color::find($id);
            $color->delete();
            return redirect()->route('colors.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
