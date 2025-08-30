<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Auth;

class WishlistController extends Controller
{
    public function index(){
        $data['wishlists'] = Wishlist::where('user_id', Auth::id())->get();

        if(session()->has('carts')){
            $data['carts'] = array_column(session()->get('carts'), 'product_id');
        }else{
            $data['carts'] = [];
        }

        return view('web.wishlist.index', $data);
    }

    public function destory($id){
        if($id){
            Wishlist::where('id', $id)->where('user_id', Auth::id())->delete();
        }
        return redirect()->back();
    }

    public function store(Request $request){
        if($request->id){
            $wishlist = Wishlist::where('product_id', $request->id)->where('user_id', Auth::id())->get();

            if(count($wishlist) == 0){

                $product = Product::find($request->id);
                if(isset($product)){
                    Wishlist::where('product_id', $request->id)->where('user_id', Auth::id())->create([
                        'product_id' => $request->id,
                        'user_id' => Auth::id(),
                    ]);

                    return response()->json(['success'=>1 ,'mgs'=>'Wishlist Product Successfully Added']);
                }else{
                    return response()->json(['error'=>1 ,'mgs'=>'Product Not Found!']);
                }

            }else{

                Wishlist::where('product_id', $request->id)->where('user_id', Auth::id())->delete();

                return response()->json(['success'=>2 ,'mgs'=>'Wishlist Product Successfully Removed']);
                
            }
        }
    }
    public function store1(Request $request){
        if($request->id){
            $wishlist = Wishlist::where('product_id', $request->id)->where('user_id', Auth::id())->get();

            if(count($wishlist) == 0){

                $product = Product::find($request->id);
                if(isset($product)){
                    Wishlist::where('product_id', $request->id)->where('user_id', Auth::id())->create([
                        'product_id' => $request->id,
                        'user_id' => Auth::id(),
                    ]);

                    return redirect()->back()->with(['success'=>1 ,'mgs'=>'Wishlist Product Successfully Added']);
                }else{
                    return redirect()->back()->with(['error'=>1 ,'mgs'=>'Product Not Found!']);
                }

            }else{

                Wishlist::where('product_id', $request->id)->where('user_id', Auth::id())->delete();

                return response()->json(['success'=>2 ,'mgs'=>'Wishlist Product Successfully Removed']);
                
            }
        }
    }
}
