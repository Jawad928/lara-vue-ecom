<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * *
     * *
     * Store Review
     */

    public function store(Request $request)
    {

        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id, $request->user()->id);

        if ($review) {

            return response()->json([

                'error' => 'You have already reviewed this product',
            ]);
        } else {


            Review::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'rating' => $request->rating,
            ]);

            return response()->json([

                'message' => 'Your review has been added and will be published soon',
            ]);
        }
    }
    public function update(Request $request)
    {
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id, $request->user()->id);

        if ($review) {

            $review->update([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'rating' => $request->rating,
                'approved' => 0,
            ]);

            return response()->json([

                'message' => 'Your reivew has been updated and will be published soon',
            ]);
        } else {

            return response()->json([

                'error' => 'Something went wrong try again later',
            ]);
        }
    }


    public function delete(Request $request)
    {

        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id, $request->user()->id);

        if ($review) {
            $review->delete();
            return response()->json([

                'message' => 'Your review has been deleted successfully',
            ]);
        } else {

            return response()->json([
                'error' => 'Something went wrong try again later',
            ]);
        }
    }

    /***
     * check if user already reviewed the product
     */

    public function checkIfUserAlreadyReviewedTheProduct($product_id, $user_id)
    {

        $review = Review::where([
            'product_id' => $product_id,
            'user_id' => $user_id,
        ])->first();


        return $review;
    }
}
