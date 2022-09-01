<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrgReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $reviews             = $organization->reviews;
        return view('organization.reviews.index', compact('organization' , 'reviews'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user            = auth()->guard('web')->user();
        $organization    = $user->organizable;
        $review          = $organization->reviews()->with('user')->where('reviews.id' , $id )->first();

        if($review)
        {
            return response()->json(['status' => true, 'data' => $review]);
        }
        else
        {
            return response()->json(['status' => false, 'data' => null]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
   
    }

  
    public function destroy($id)
    {
        $user            = auth()->guard('web')->user();
        $organization    = $user->organizable;
        $review          = $organization->reviews()->where('reviews.id' , $id )->first();

        if($review)
        {
            $review->delete();
            return redirect()->route('organization.review.index')->with('success' , __('message.deleted_successfully'));
        }

        else 
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
      

    }
}
