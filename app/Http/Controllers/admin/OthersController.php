<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complain;
use App\Models\KeyValueSetting;
use Validator;

class OthersController extends Controller
{
    public function complains(Request $request){
        $search = $request->search;
        $data['complains'] = Complain::where(function ($query) use ($search){
                if($search){
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->orWhere('inquery', 'like', '%'.$search.'%')
                        ->orWhere('message', 'like', '%'.$search.'%')
                        ->orWhere('order_no', 'like', '%'.$search.'%');
                }
            })
            ->orderBy('status', 'asc')
            ->paginate(10);

        return view('admin.others.complain', $data);
    }

    public function markComplainRead(Request $request)
    {
        $request->validate(['id' => 'required|exists:complains,id']);

        Complain::where('id', $request->id)->update(['status' => 1]);
        return response()->json(['success' => true, 'mgs' => 'Marked as read']);
    }

    public function shippingDetails(){
        $value = $this->getValueByKey('shipping_details');
        return view('admin.others.shipping_details', compact('value'));
    }
    public function shippingDetails_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('shipping_details', $request);

            return response()->json(['success' => true, 'mgs' => 'Shipping Details Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function bannerGallary(){
        $value = $this->getValueByKey('banner_gallery');
        return view('admin.others.banner_gallery', compact('value'));
    }
    public function bannerGallary_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('banner_gallery', $request);

            return response()->json(['success' => true, 'mgs' => 'Banner Gallery Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function howToOrder(){
        $value = $this->getValueByKey('how_to_order');
        return view('admin.others.how_to_order', compact('value'));
    }
    public function howToOrder_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('how_to_order', $request);

            return response()->json(['success' => true, 'mgs' => 'How to Order Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function contactUs(){
        $value = $this->getValueByKey('contact_us');
        return view('admin.others.contact_us', compact('value'));
    }
    public function contactUs_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('contact_us', $request);

            return response()->json(['success' => true, 'mgs' => 'Contact Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function privacyPolicy(){
        $value = $this->getValueByKey('privacy_policy');
        return view('admin.others.privacy_policy', compact('value'));
    }
    public function privacyPolicy_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('privacy_policy', $request);

            return response()->json(['success' => true, 'mgs' => 'Privacy Policy Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function physicalStore(){
        $value = $this->getValueByKey('physical_store');
        return view('admin.others.physical_store', compact('value'));
    }
    public function physicalStore_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('physical_store', $request);

            return response()->json(['success' => true, 'mgs' => 'Physical Store Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function termsConditions(){
        $value = $this->getValueByKey('terms_and_conditions');
        return view('admin.others.terms_and_conditions', compact('value'));
    }
    public function termsConditions_store(Request $request){
        $validator =  Validator::make($request->all(), [
            'value' => 'required',
        ]);
        if ($validator->passes()) {
            $value = $this->storeValueByKey('terms_and_conditions', $request);

            return response()->json(['success' => true, 'mgs' => 'Terms & Conditions Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    private function getValueByKey($key){
        $data = KeyValueSetting::where('key', $key)->first();
        if(!empty($data)){
            $value = $data->value;
        }else{
            $value = '';
        }
        return $value;
    }
    private function storeValueByKey($key, $request){
        $data = KeyValueSetting::where('key', $key);
        if($data->exists()){
            $data->update(['value'=>$request->value]);
        }else{
            KeyValueSetting::create([
                'key'=>$key,
                'value'=>$request->value,
            ]);
        }
        return;
    }
}
