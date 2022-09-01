<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgBranchController extends Controller
{
    public function index()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $branches     = $organization->branches;

        return view('organization.branches.index' , compact('organization' , 'branches'));
    }

    public function create()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $categories = Category::whereHas('section' , function(Builder $query) use($organization){

            $query->where('ref_name' , $organization->ref_name );

        })->get();
        $countries = Country::get();
        $vehicles  = $organization->vehicles ?? [];
        $products  = $organization->products ?? [];
        $services  = $organization->services ?? [];
        return view('organization.branches.create' , compact('categories' , 'countries' , 'vehicles', 'products' , 'services'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name_en'     => 'required|max:255',
            'name_ar'     => 'required|max:255',
            'address_en'  => 'required',
            'address_ar'  => 'required',
            'city_id'     => 'nullable|exists:cities,id',
            'area_id'     => 'nullable|exists:areas,id',
            'category_id' => 'required|exists:categories,id',
            'longitude'   => 'max:255',
            'latitude'    => 'max:255',
            'vehicles'    => 'nullable|array',
            'vehicles.*'  => 'exists:vehicles,id',
            'products'    => 'nullable|array',
            'products.*'  => 'exists:products,id',
            'services'    => 'nullable|array',
            'services.*'  => 'exists:services,id',

            'from'      => 'required',
            'to'        => 'required',
            'duration'  => 'required|numeric',
            'work_days' => 'required|array',

            'facebook_link'    => 'nullable|url',
            'whatsapp_number'  => 'nullable|max:255',
            'country_code'            => 'required',
            'phone'            => 'nullable|integer',
            'website'          => 'nullable|url',
            'instagram_link'   => 'nullable|url',

            'user_name'        => 'required|max:255|unique:organization_users,user_name',
            'email'            => 'required|max:255|email|unique:organization_users,email',
            'password'         => 'required|max:255',
        ];
        /*$validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return $validator->errors();
        }*/

        $request->validate($rules);

        if (!$request->has('availability'))
            $request->request->add(['availability' => 0]);
        else
            $request->request->add(['availability' => 1]);

        if (!$request->has('reservation_availability'))
            $request->request->add(['reservation_availability' => 0]);
        else
            $request->request->add(['reservation_availability' => 1]);

        if (!$request->has('delivery_availability'))
            $request->request->add(['delivery_availability' => 0]);
        else
            $request->request->add(['delivery_availability' => 1]);

        $request->merge([
            'days' => implode("," , $request->work_days )
        ]);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $branch = $organization->branches()->create($request->all());
        /* uses */
        if($request->filled('vehicles')) //vehicles should belongs to this org
        {
            $branch->available_vehicles()->attach($request->vehicles);
        }
        if($request->filled('products')) //products should belongs to this org
        {
            $branch->available_products()->attach($request->products);
        }
        if($request->filled('services')) //services should belongs to this org
        {
            $branch->available_services()->attach($request->services);
        }
        /* work time */
        $branch->work_time()->create($request->only(['from' , 'to' , 'duration' , 'days']));
        /* contact */
        $branch->contact()->create($request->only(['facebook_link' , 'whatsapp_number' ,'country_code', 'phone' , 'website' , 'instagram_link']));
        /*use branch */
        $branch->organization_users()->create($request->only(['user_name' , 'email' , 'password']));

        return redirect()->route('organization.branch.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $branch = $organization->branches()->where('branches.id' , $id)->firstOrFail();
        $users     = $branch->organization_users;
        $categories = Category::whereHas('section' , function(Builder $query) use($organization){

            $query->where('ref_name' , $organization->ref_name );

        })->get();

        $countries = Country::get();
        $vehicles  = $organization->vehicles ?? [];
        $products  = $organization->products ?? [];
        $services  = $organization->services ?? [];

        $country_id = $branch->city ? $branch->city->country_id : null;

        $cities    = City::where('country_id' , $country_id)->get();

        $areas     = Area::where('city_id'   , $branch->city_id)->get();

        return view('organization.branches.edit' , compact('organization' ,'users', 'vehicles' , 'products' , 'services' , 'branch' , 'countries', 'cities' , 'areas' , 'categories'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'name_en'     => 'required|max:255',
            'name_ar'     => 'required|max:255',
            'address_en'  => 'required',
            'address_ar'  => 'required',
            'city_id'     => 'nullable|exists:cities,id',
            'area_id'     => 'nullable|exists:areas,id',
            'category_id' => 'required|exists:categories,id',
            'longitude'   => 'max:255',
            'latitude'    => 'max:255',
            'vehicles'    => 'nullable|array',
            'vehicles.*'  => 'exists:vehicles,id',
            'products'    => 'nullable|array',
            'products.*'  => 'exists:products,id',
            'services'    => 'nullable|array',
            'services.*'  => 'exists:services,id',

            'from'      => 'required',
            'to'        => 'required',
            'duration'  => 'required|numeric',
            'work_days' => 'required|array',

            'facebook_link'    => 'nullable|url',
            'whatsapp_number'  => 'nullable|max:255',
            'country_code'            => 'required',
            'phone'            => 'nullable|integer',
            'website'          => 'nullable|url',
            'instagram_link'   => 'nullable|url',
            'email' => 'nullable|email|unique:organization_users,email,'.$id,
            'password' => 'nullable|confirmed',
            'password_confirmation' => 'nullable|same:password',
            'user_name' => 'required',
        ];

        $request->validate($rules);

        if (!$request->has('availability'))
            $request->request->add(['availability' => 0]);
        else
            $request->request->add(['availability' => 1]);

        if (!$request->has('reservation_availability'))
            $request->request->add(['reservation_availability' => 0]);
        else
            $request->request->add(['reservation_availability' => 1]);

        if (!$request->has('delivery_availability'))
            $request->request->add(['delivery_availability' => 0]);
        else
            $request->request->add(['delivery_availability' => 1]);

        $request->merge([
            'days' => implode("," , $request->work_days )
        ]);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $branch = $organization->branches()->where('branches.id' , $id)->firstOrFail();
        /* uses */
        $branch->available_vehicles()->sync($request->vehicles); //vehicles should belongs to this org

        $branch->available_products()->sync($request->products); ////products should belongs to this org

        $branch->available_services()->sync($request->services);  //services should belongs to this org

        /* work time */
        if($branch->work_time)
        {
            $branch->work_time()->update($request->only(['from' , 'to' , 'duration' , 'days']));
        }
        else
        {
            $branch->work_time()->create($request->only(['from' , 'to' , 'duration' , 'days']));
        }
        /* contact */
        if($branch->contact)
        {
            $branch->contact()->update($request->only(['facebook_link' , 'whatsapp_number' ,'country_code', 'phone' , 'website' , 'instagram_link']));
        }
        else
        {
            $branch->contact()->create($request->only(['facebook_link' , 'whatsapp_number' ,'country_code', 'phone' , 'website' , 'instagram_link']));
        }

        if(!$request->area_id)
        {
            $request->merge(['area_id' => null]);
        }

        /* user */
        $user = $branch->organization_users()->find($request->organization_user_id);
        if ($request->user_name) {

            $user->update([
                'user_name' => $request->user_name,
            ]);
        }
        if ($request->password){

            $user->update([
                'password' => $request->password,
            ]);
        }

        $branch->update($request->all());


        return redirect()->route('organization.branch.index')->with('success' , __('message.updated_successfully'));
    }

    public function destroy($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $branch = $organization->branches()->where('branches.id' , $id)->firstOrFail();


        if($branch)
        {
            $branch->delete();
            return redirect()->route('organization.branch.index')->with('success' , __('message.deleted_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
