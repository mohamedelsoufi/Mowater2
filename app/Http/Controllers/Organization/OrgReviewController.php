<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class OrgReviewController extends Controller
{
    private $review;

    public function __construct(Review $review)

    {
        $this->middleware(['HasOrgReview:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgReview:delete'])->only('destroy');
        $this->review = $review;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $reviews = $record->reviews;
            return view('organization.reviews.index', compact('record', 'reviews'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $review = $this->review->find($id);

            return view('organization.reviews.show', compact('record', 'review'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $review = $this->review->find($id);
            $review->delete();
            return redirect()->route('organization.reviews.index')->with('success', __('message.deleted_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }
}
