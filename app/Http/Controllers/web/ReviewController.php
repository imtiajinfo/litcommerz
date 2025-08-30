<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Validator;
use Auth;

class ReviewController extends Controller
{
    public function store(Request $request){
        $validator =  Validator::make($request->all(), [
            "product_id" => "required",
            "review" => "required",
            "userRating" => "required",
        ]);

        if ($validator->passes()) {
            Review::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'review'     => $request->review,
                'rating'     => $request->userRating,
            ]);
            return response()->json(['success'=>true, 'mgs'=>'Review Added Successfully']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
}
