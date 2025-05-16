<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /***
     *
     * Display all reviews
     *
     */

    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    /****
     *approve or disapprove a review
     */

    public function toggleApproveStatus(Review $review, $status)
    {
        $review->update([
            'approved' => $status,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully');
    }


    /***
     *
     * Delete review
     */

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully');
    }
}
