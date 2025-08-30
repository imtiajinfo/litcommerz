<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use App\Models\Region;
use Validator;
use Str;

class DeliveryChargeController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 10;
        $search = $request->search ?? '';

        $data['deliveryCharges'] = DeliveryCharge::with('region')
            ->whereHas('region', function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            })
            ->orWhere('city', 'like', '%'.$search.'%')
            ->orderBy('id', 'desc')
            ->paginate($perpage);

        $data['search'] = $search;
        return view('admin.delivery_charge.index', $data);
    }

    public function create()
    {
        $data['regions'] = Region::all();
        return view('admin.delivery_charge.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required|exists:regions,id',
            'city'      => 'required|unique:delivery_charges,city,NULL,id,region_id,' . $request->region_id,
            'charge'    => 'required|numeric',
        ]);

        if ($validator->passes()) {
            DeliveryCharge::create([
                'region_id' => $request->region_id,
                'city'      => $request->city,
                'charge'    => $request->charge,
            ]);
            return response()->json(['success' => true, 'mgs' => 'Delivery Charge Created']);
        } else {
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    public function edit($id)
    {
        $data['deliveryCharge'] = DeliveryCharge::findOrFail($id);
        $data['regions'] = Region::all();
        return view('admin.delivery_charge.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required|exists:regions,id',
            'city'      => 'required|unique:delivery_charges,city,'.$id.',id,region_id,' . $request->region_id,
            'charge'    => 'required|numeric',
        ]);

        if ($validator->passes()) {
            $deliveryCharge = DeliveryCharge::findOrFail($id);
            $deliveryCharge->update([
                'region_id' => $request->region_id,
                'city'      => $request->city,
                'charge'    => $request->charge,
            ]);
            return response()->json(['success' => true, 'mgs' => 'Delivery Charge Updated']);
        } else {
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    public function destroy($id)
    {
        DeliveryCharge::findOrFail($id)->delete();
        return response()->json(['success' => true, 'mgs' => 'Delivery Charge Deleted']);
    }
}