<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-currencies'])->only('index');
        $this->middleware(['permission:create-currencies'])->only('create');
        $this->middleware(['permission:update-currencies'])->only('edit');
        $this->middleware(['permission:delete-currencies'])->only('delete');
    }

    public function index()
    {
        try {
            $currencies = Currency::all();
            return view('admin.general.currencies.index', compact('currencies'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function create()
    {
        return view('admin.general.currencies.create');
    }

    public function store(CurrencyRequest $request)
    {
        try {
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            Currency::create($request_data);
            return redirect()->route('currencies.index')->with(['success' => __('message.created_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        try {
            $currency = Currency::find($id);
            return view('admin.general.currencies.show', compact('currency'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function edit($id)
    {
        try {
            $currency = Currency::find($id);
            return view('admin.general.currencies.edit', compact('currency'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(CurrencyRequest $request, $id)
    {
        try {
            $currency = Currency::find($id);
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $currency->update($request_data);
            return redirect()->route('currencies.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $currency = Currency::find($id);
            $currency->delete();
            return redirect()->route('currencies.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
