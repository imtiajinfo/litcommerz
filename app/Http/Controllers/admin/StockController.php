<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockLedger;
use App\Models\Product;
use App\Models\StockSummery;
use Validator;
use Auth;
use DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';

        $data['stock_ledgers'] = StockLedger::join('products', 'products.id', '=', 'stock_ledgers.product_id')
            ->orderBy('stock_ledgers.id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('products.product_name', 'like', '%'.$search.'%');
            })
            ->select('stock_ledgers.id', 'products.product_name', 'stock_ledgers.qty', 'stock_ledgers.type', 'stock_ledgers.product_id')
            ->paginate($perpage);

        return view('admin.stocks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['products'] = Product::all();
        return view('admin.stocks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'product_id' => 'required',
            'qty'        => 'required',
            'buy_price'  => 'required',
            'sell_price' => 'required',
        ]);
        if ($validator->passes()) {

            DB::beginTransaction();

            $stock_ledger = StockLedger::create([
                'user_id'       => Auth::id(),
                'order_id'      => 0,
                'product_id'    => $request->product_id,
                'type'          => 1,
                'qty'           => $request->qty,
            ]);
    
            StockSummery::create([
                'stock_id'   => $stock_ledger->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->qty,
                'amount'     => $request->buy_price,
                'sell_price' => $request->sell_price,
            ]);

            $product = Product::find($request->product_id);

            $product->update([
                'sell_price'      => $request->sell_price,
                'available_stock' => $product->available_stock + $request->qty,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'mgs' => 'Stock Successfully Stored']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }

        
    }

}
