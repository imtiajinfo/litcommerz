<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courier;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::orderBy('id','desc')->get();
        return view('admin.couriers.index', compact('couriers'));
    }

    public function create()
    {
        return view('admin.couriers.create');
    }

    public function store(Request $request)
    {
        $data = $request->only(['name','client_id','secret_id','api_key','api_url','status']);
        Courier::create($data);
        return response()->json(['success'=>true,'mgs'=>'Courier Successfully Created']);
    }

    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('admin.couriers.edit', compact('courier'));
    }

    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);
        $data = $request->only(['name','client_id','secret_id','api_key','api_url','status']);
        $courier->update($data);
        return response()->json(['success'=>true,'mgs'=>'Courier Successfully Updated']);
    }

    public function destroy($id)
    {
        Courier::findOrFail($id)->delete();
        return response()->json(['success'=>true,'mgs'=>'Courier Successfully Deleted']);
    }
}