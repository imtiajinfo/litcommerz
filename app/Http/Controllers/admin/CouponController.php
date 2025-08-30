<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CouponCategory;
use App\Models\Coupon;
use Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 10;
        $search = $request->search ?? '';

        $coupons = Coupon::where('name', 'like', '%'.$search.'%')
            ->orderBy('id', 'desc')
            ->paginate($perpage);

        return view('admin.coupon.index', compact('coupons', 'perpage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = CouponCategory::all();
        return view('admin.coupon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            // 'category' => 'required',
            'coupon_name' => 'required',
            'minimum_sale_amount' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'end_date' => 'required',
            'status' => 'required',
            'image'    => 'required|image|mimes:jpeg,png,jpg|dimensions:width=900,height=330',
            'amount' => $request->type == 1 ? 'required|numeric|min:1' : 'required|numeric|min:1|max:100',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('coupon_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/coupon/'), $imageName);
            }

            $coupon = new Coupon();
            $coupon->name         = $request->coupon_name;
            // $coupon->category_id         = $request->category;
            $coupon->minimum_sale_amount = $request->minimum_sale_amount;
            $coupon->amount              = $request->amount;
            $coupon->coupon_code         = $request->coupon_code;
            $coupon->start_date          = $request->start_date;
            $coupon->end_date            = $request->end_date;
            $coupon->status              = $request->status;
            $coupon->banner               = $imageName;
            $coupon->type = $request->type;
            $coupon->save();

            return response()->json(['success' => true, 'mgs' => 'Coupon Successfully Created']);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['categories'] = CouponCategory::all();
        $data['coupon'] = Coupon::findOrFail($id);
        return view('admin.coupon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            // 'category'            => 'required',
            'coupon_name'         => 'required',
            'minimum_sale_amount' => 'required',
            'start_date'          => 'required',
            'end_date'            => 'required',
            'coupon_code'         => 'required|unique:coupons,coupon_code,' . $id,
            'status'              => 'required',
            'amount'              => $request->type == 1
                                    ? 'required|numeric|min:1'
                                    : 'required|numeric|min:1|max:100',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg|dimensions:width=900,height=330';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error'   => true,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->coupon_name) . '-' . now()->format('d.m.Y.h.s') . '.' . $request->image->extension();
            $request->image->move(public_path('frontend/images/coupon/'), $imageName);
        }

        $coupon = Coupon::findOrFail($id);
        $coupon->name                 = $request->coupon_name;
        // $coupon->category_id          = $request->category;
        $coupon->coupon_code          = $request->coupon_code;
        $coupon->minimum_sale_amount  = $request->minimum_sale_amount;
        $coupon->amount               = $request->amount;
        $coupon->start_date           = $request->start_date;
        $coupon->end_date             = $request->end_date;
        $coupon->status               = $request->status;
        $coupon->type                 = $request->type;

        if ($request->hasFile('image')) {
            if ($coupon->banner) {
                @unlink(public_path('frontend/images/coupon/' . $coupon->banner));
            }
            $coupon->banner = $imageName;
        }

        $coupon->save();

        return response()->json(['success' => true, 'mgs' => 'Coupon Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            Coupon::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Coupon Successfully Deleted']);
        }
    }
}
