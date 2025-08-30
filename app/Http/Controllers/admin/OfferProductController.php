<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Product;
use App\Models\OfferProduct;
use Validator;
use Str;

class OfferProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $offer_id = $data['offer_id'] = $request->offer_id;
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['offers'] = Offer::join('offer_products', 'offer_products.offer_id', '=', 'offers.id')
            ->join('products', 'products.id', '=', 'offer_products.product_id')
            ->orderBy('offers.id', 'desc')
            ->where('offers.id', $offer_id)
            ->where(function ($query) use ($search){
                $query->where('products.product_name', 'like', '%'.$search.'%');
            })
            ->select('offers.*', 'products.product_name', 'products.id as product_id', 'offer_products.amount', 'offer_products.is_percentage', 'offer_products.percentage', 'offer_products.id')
            ->paginate($perpage);
        

        return view('admin.offer_products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $offer_id = $data['offer_id'] = $request->offer_id;
        $pro_ids = Offer::join('offer_products', 'offer_products.offer_id', '=', 'offers.id')
                    ->orderBy('offers.id', 'desc')
                    ->where('offers.id', $offer_id)
                    ->pluck('offer_products.product_id')
                    ->toArray();

        $data['products'] = Product::whereNotIn('id', $pro_ids)->get();

        return view('admin.offer_products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
            'product_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $existsInSameOffer = OfferProduct::where('offer_id', $request->offer_id)
                                                    ->where('product_id', $value)
                                                    ->exists();

                    $existsInOtherOffer = OfferProduct::where('product_id', $value)
                                                    ->where('offer_id', '!=', $request->offer_id)
                                                    ->exists();

                    if ($existsInSameOffer) {
                        $fail('This product is already assigned to this offer.');
                    } elseif ($existsInOtherOffer) {
                        $fail('This product is assigned to another offer.');
                    }
                },
            ],
            'value' => 'required',
        ]);

        if ($validator->passes()) {

            $offer = new OfferProduct();
            $offer->offer_id      = $request->offer_id;
            $offer->product_id    = $request->product_id;
            $offer->is_percentage = $request->is_percentage == 1 ? 1 : 2;
            $offer->amount        = $request->is_percentage == 1 ? 0 : $request->value;
            $offer->percentage    = $request->is_percentage == 1 ? $request->value : 0;
            $offer->save();

            $product = Product::find($request->product_id);

            if ($product) {
                if ($request->is_percentage == 1) {
                    // Calculate amount as percentage of sell_price
                    $product->offer_amount = ($product->sell_price * $request->value) / 100;
                } else {
                    // Fixed amount
                    $product->offer_amount = $request->value;
                }
                $product->save();
            }


            return response()->json(['success' => true, 'mgs' => 'Offer Product Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
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
    public function edit(Request $request, string $id)
    {
        $offerProduct = OfferProduct::findOrFail($id);
        $offer_id = $data['offer_id'] = $offerProduct->offer_id;
        $product_id = $request->product_id;
        $pro_ids = Offer::join('offer_products', 'offer_products.offer_id', '=', 'offers.id')
                    ->where('offers.id', $offer_id)
                    ->pluck('offer_products.product_id')
                    ->toArray();

        $data['products'] = Product::whereNotIn('id', $pro_ids)->orWhere('id', $product_id)->get();
        $data['offer'] = Offer::join('offer_products', 'offer_products.offer_id', '=', 'offers.id')
            ->where('offers.id', $offer_id)
            ->where('offer_products.product_id', $product_id)
            ->select('offers.*', 'offer_products.amount', 'offer_products.is_percentage', 'offer_products.percentage', 'offer_products.product_id as product_id', 'offer_products.id as offer_product_id')
            ->first();

        return view('admin.offer_products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
            'product_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $existsInSameOffer = OfferProduct::where('offer_id', $request->offer_id)
                                                    ->where('product_id', $value)
                                                    ->where('id', '!=', $id)
                                                    ->exists();

                    $existsInOtherOffer = OfferProduct::where('product_id', $value)
                                                    ->where('offer_id', '!=', $request->offer_id)
                                                    ->where('id', '!=', $id)
                                                    ->exists();

                    if ($existsInSameOffer) {
                        $fail('This product is already assigned to this offer.');
                    } elseif ($existsInOtherOffer) {
                        $fail('This product is assigned to another offer.');
                    }
                },
            ],
            'value' => 'required',
        ]);

        if ($validator->passes()) {

            $offer = OfferProduct::findOrFail($id);
            $offer->offer_id      = $request->offer_id;
            $offer->product_id    = $request->product_id;
            $offer->is_percentage = $request->is_percentage == 1 ? 1 : 2;
            $offer->amount        = $request->is_percentage == 1 ? 0 : $request->value;
            $offer->percentage    = $request->is_percentage == 1 ? $request->value : 0;
            $offer->save();

            $product = Product::find($request->product_id);

            if ($product) {
                if ($request->is_percentage == 1) {
                    $product->offer_amount = ($product->sell_price * $request->value) / 100;
                } else {
                    $product->offer_amount = $request->value;
                }
                $product->save();
            }

            return response()->json(['success' => true, 'mgs' => 'Offer Product Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $offerProduct = OfferProduct::find($id);
        if ($offerProduct) {
            $product = Product::find($offerProduct->product_id);
            if ($product) {
                $product->offer_amount = 0;
                $product->save();
            }
            $offerProduct->delete();
            return response()->json(['success' => true, 'mgs' => 'Offer Product Successfully Deleted']);
        }
        return response()->json(['success' => false, 'mgs' => 'Offer Product not found'], 404);
    }
}
