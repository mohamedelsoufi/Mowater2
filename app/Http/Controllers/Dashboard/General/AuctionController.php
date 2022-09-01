<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuctionRequest;
use App\Models\Auction;
use App\Models\Product;
use App\Models\SpecialNumber;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auctions = Auction::all();
        $products = Product::where('active', 1)->where('available', 1)->get();
        $specialnumbers = SpecialNumber::where('availability', 1)->get();
        $vehicles = Vehicle::with('brand', 'car_model', 'car_class')->where('availability', 1)->get();
        return view('dashboard.general.auctions.index', compact('auctions', 'products', 'specialnumbers', 'vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products_organizations = Product::where('active', 1)->where('available', 1)->groupBy('productable_id')->groupBy('productable_type')->get();
        $specialnumbers = SpecialNumber::where('availability', 1)->get();
        $vehicles_organizations = Vehicle::where('availability', 1)->groupBy('vehicable_id')->groupBy('vehicable_type')->get();
        foreach ($products_organizations as $key => $org) {
            $model = new $org->productable_type;
            $products_organizations[$key]['object'] = $model->find($org->productable_id);
            $products_organizations[$key]['type'] = str_replace("App\\Models\\", "", $org->productable_type);
        }
        foreach ($vehicles_organizations as $key => $org) {
            $model = new $org->vehicable_type;
            $vehicles_organizations[$key]['object'] = $model->find($org->vehicable_id);
            $vehicles_organizations[$key]['type'] = str_replace("App\\Models\\", "", $org->vehicable_type);
        }
        return view('dashboard.general.auctions.create', compact('products_organizations', 'vehicles_organizations', 'specialnumbers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuctionRequest $request)
    {
        if ($request->has('product_id') || $request->has('special_number_id') || $request->has('vehicle_id')) {
//            return $request;
            $auctionable_type = "App\\Models\\" . $request->type;
            if ($request->type == "Product") {
                $auctionable_id = $request->product_id;

            } elseif ($request->type == "SpecialNumber") {
                $auctionable_id = $request->special_number_id;
            } elseif ($request->type == "Vehicle") {
                $auctionable_id = $request->vehicle_id;
            }
            $request['active'] = 1;
//            return $request;
            if ($request->start_date != $request->end_date) {
                if ($request->start_date >= Carbon::now()->format('Y-m-d')) {
                    if ($request->end_date > $request->start_date) {
//                        return $request;
                        if ($auctionable_type && $auctionable_id) {
                            $auction = Auction::create([
                                'price' => $request->price,
                                'title_ar' => $request->title_ar,
                                'title_en' => $request->title_en,
                                'insurance_amount' => $request->insurance_amount,
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date,
                                'active' => 1,
                                'type' => $request->type,
                                'auctionable_type' => $auctionable_type,
                                'auctionable_id' => $auctionable_id
                            ]);
                            return redirect()->route('auctions.index')->with(['success' => __('message.created_successfully')]);

                        } else {
                            return redirect()->back()->withInput($request->input())->with(['error' => __('message.type_details_required')]);
                        }
                    } else {
                        return redirect()->back()->withInput($request->input())->with(['error' => __('message.end_date_is_old')]);
                    }
                } else {
                    return redirect()->back()->withInput($request->input())->with(['error' => __('message.start_date_is_old')]);
                }
            } else {
                return redirect()->back()->withInput($request->input())->with(['error' => __('message.same_dates')]);
            }

        } else {
            return redirect()->back()->withInput($request->input())->with(['error' => __('message.type_details_required')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        $auction = Auction::with('auctionable')->find($id);
        $products_organizations = Product::where('active', 1)->where('available', 1)->groupBy('productable_id')->groupBy('productable_type')->get();
        $specialnumbers = SpecialNumber::where('availability', 1)->get();
        $vehicles_organizations = Vehicle::where('availability', 1)->groupBy('vehicable_id')->groupBy('vehicable_type')->get();
        $selected_product = "";
        $selected_vehicle = "";
        $vehicles = [];
        $products = [];
        foreach ($products_organizations as $key => $org) {
            $model = new $org->productable_type;
            $products_organizations[$key]['object'] = $model->find($org->productable_id);
            $org_products = $products_organizations[$key]['object']->products;
            $products_organizations[$key]['type'] = str_replace("App\\Models\\", "", $org->productable_type);
            if ($auction->type == "Product") {
                $product = Product::find($auction->auctionable_id);
                foreach ($org_products as $org_product) {
                    if ($org_product->id == $product->id) {
                        $products = $products_organizations[$key]['object']->products;
                        $selected_product = $key;
                    }
                }
            }
        }
        foreach ($vehicles_organizations as $key => $org) {
            $model = new $org->vehicable_type;
            $vehicles_organizations[$key]['object'] = $model->find($org->vehicable_id);
            $vehicles_organizations[$key]['type'] = str_replace("App\\Models\\", "", $org->vehicable_type);
            $org_vehicles = $vehicles_organizations[$key]['object']->vehicles;

            if ($auction->type == "Vehicle") {
                $vehicle = Vehicle::find($auction->auctionable_id);
                foreach ($org_vehicles as $org_vehicle) {
                    if ($org_vehicle->id == $vehicle->id) {
                        $vehicles = $vehicles_organizations[$key]['object']->vehicles()->with('brand', 'car_model', 'car_class')->get();
                        $selected_vehicle = $key;
                    }
                }
            }
        }
//        return $vehicles;
        return view('dashboard.general.auctions.edit', compact('auction', 'specialnumbers', 'products', 'vehicles', 'products_organizations', 'vehicles_organizations', 'selected_product', 'selected_vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(AuctionRequest $request, $id)
    {
        $auction = Auction::find($id);
        if ($request->has('product_id') || $request->has('special_number_id') || $request->has('vehicle_id')) {
            $auctionable_type = "App\\Models\\" . $request->type;
            if ($request->has('active'))
                $request['active'] = 1;
            else
                $request['active'] = 0;
            if ($request->type == "Product") {
                $auctionable_id = $request->product_id;
                $request->merge(['auctionable_type' => $auctionable_type, 'auctionable_id' => $auctionable_id]);
//                return $request;
                $request_data = $request->except('product_id');
            } elseif ($request->type == "SpecialNumber") {
                $auctionable_id = $request->special_number_id;
                $request->merge(['auctionable_type' => $auctionable_type, 'auctionable_id' => $auctionable_id]);
                $request_data = $request->except('special_number_id');
            } elseif ($request->type == "Vehicle") {
                $auctionable_id = $request->vehicle_id;
                $request->merge(['auctionable_type' => $auctionable_type, 'auctionable_id' => $auctionable_id]);
                $request_data = $request->except('vehicle_id');
            }
            $auction->update($request_data);
            return redirect()->route('auctions.index')->with(['success' => __('message.updated_successfully')]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public function org_products($object)
    {
//        $products = $object->products;
        $object = explode(",", $object);
        $class = "App\\Models\\" . $object[1];
        $id = $object[0];
        $obj = new $class;
        $products = $obj->find($id)->products;
        $data = compact('products');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function org_vehicles($object)
    {
        $object = explode(",", $object);
        $class = "App\\Models\\" . $object[1];
        $id = $object[0];
        $obj = new $class;
        $vehicles = $obj->find($id)->vehicles()->with('brand', 'car_model', 'car_class')->get();
        $data = compact('vehicles');
        return response()->json(['status' => true, 'data' => $data]);
    }
}
