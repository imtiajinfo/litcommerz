<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Validator;

class PaymentGatewayController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';

        $data['gateways'] = PaymentGateway::when($search, function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.payment_gateway.index', $data);
    }

    public function create()
    {
        return view('admin.payment_gateway.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mode' => 'required|in:sandbox,live',
            'status' => 'required|boolean',
        ]);

        if ($validator->passes()) {
            PaymentGateway::create($request->only([
                'name','client_id','secret_id','merchant_id','mode','status'
            ]));

            return response()->json(['success' => true, 'mgs' => 'Payment Gateway Successfully Created']);
        } else {
            return response()->json(['error' => true, 'mgs' => $validator->errors()]);
        }
    }

    public function edit($id)
    {
        $data['gateway'] = PaymentGateway::findOrFail($id);
        return view('admin.payment_gateway.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mode' => 'required|in:sandbox,live',
            'status' => 'required|boolean',
        ]);

        if ($validator->passes()) {
            $gateway = PaymentGateway::findOrFail($id);
            $gateway->update($request->only([
                'name','client_id','secret_id','merchant_id','mode','status'
            ]));

            return response()->json(['success' => true, 'mgs' => 'Payment Gateway Successfully Updated']);
        } else {
            return response()->json(['error' => true, 'mgs' => $validator->errors()]);
        }
    }

    public function destroy($id)
    {
        PaymentGateway::findOrFail($id)->delete();
        return response()->json(['success' => true, 'mgs' => 'Payment Gateway Successfully Deleted']);
    }
}