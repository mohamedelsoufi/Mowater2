<?php

namespace App\Http\Controllers\Dashboard\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-countries'])->only('index');
        $this->middleware(['permission:create-countries'])->only('create');
        $this->middleware(['permission:update-countries'])->only('edit');
        $this->middleware(['permission:delete-countries'])->only('delete');
    }

    public function index()
    {
        try {
            $countries = Country::latest('id')->get();
            return view('admin.location.countries.index', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $country = Country::find($id);
            return view('admin.location.countries.show', compact('country'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $currencies = Currency::latest('id')->get();
            return view('admin.location.countries.create', compact('currencies'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(CountryRequest $request)
    {
        try {
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $country = Country::create($request_data);
            $image = $country->refresh();
            $image->uploadImage();

            return redirect()->route('countries.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $country = Country::find($id);
            $currencies = Currency::latest('id')->get();
            return view('admin.location.countries.edit', compact('country', 'currencies'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(CountryRequest $request, $id)
    {
        try {
            $country = Country::find($id);
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $country->update($request_data);
            $country->updateImage();
            return redirect()->route('countries.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $country = Country::find($id);
            $country->deleteImage();
            $country->delete();
            return redirect()->route('countries.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
