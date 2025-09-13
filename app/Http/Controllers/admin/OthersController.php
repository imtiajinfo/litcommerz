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

    // Shipping Details
    public function shippingDetails()
    {
        $data = $this->getValueByKey('shipping_details');
        return view('admin.others.shipping_details', $data);
    }

    public function shippingDetails_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('shipping_details', $request);

        return response()->json(['success' => true, 'mgs' => 'Shipping Details Successfully Updated']);
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
    public function howToOrder()
    {
        $data = $this->getValueByKey('how_to_order');
        return view('admin.others.how_to_order', $data);
    }

    public function howToOrder_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('how_to_order', $request);

        return response()->json(['success' => true, 'mgs' => 'How to Order Successfully Updated']);
    }
    public function contactUs()
    {
        $data = $this->getValueByKey('contact_us');
        return view('admin.others.contact_us', $data);
    }

    public function contactUs_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('contact_us', $request);

        return response()->json(['success' => true, 'mgs' => 'Contact Section Successfully Updated']);
    }
    public function privacyPolicy()
    {
        $privacyData = $this->getValueByKey('privacy_policy');
        return view('admin.others.privacy_policy', $privacyData);
    }

    public function privacyPolicy_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('privacy_policy', $request);

        return response()->json(['success' => true, 'mgs' => 'Privacy Policy Successfully Updated']);
    }

    public function aboutUs()
    {
        $aboutData = $this->getValueByKey('about_us');
        return view('admin.others.about_us', $aboutData);
    }

    public function aboutUs_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('about_us', $request);

        return response()->json(['success' => true, 'mgs' => 'About Us Successfully Updated']);
    }

    public function faq()
    {
        $data = $this->getValueByKey('faq');
        return view('admin.others.faq', $data);
    }

    public function faq_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('faq', $request);

        return response()->json(['success' => true, 'mgs' => 'FAQ Successfully Updated']);
    }

    public function physicalStore()
    {
        $data = $this->getValueByKey('physical_store');
        return view('admin.others.physical_store', $data);
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
    // Terms & Conditions
    public function termsConditions()
    {
        $tcData = $this->getValueByKey('terms_and_conditions');
        return view('admin.others.terms_and_conditions', $tcData);
    }

    public function termsConditions_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_alt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $this->storeValueByKey('terms_and_conditions', $request);

        return response()->json(['success' => true, 'mgs' => 'Terms & Conditions Successfully Updated']);
    }

    private function getValueByKey($key)
    {
        $data = KeyValueSetting::where('key', $key)->first();

        if (!$data) {
            // Return defaults if record not found
            return [
                'value' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'meta_og_image' => '',
                'meta_og_alt' => '',
                'image_alt' => '',
            ];
        }

        return [
            'value' => $data->value ?? '',
            'meta_title' => $data->meta_title ?? '',
            'meta_description' => $data->meta_description ?? '',
            'meta_keywords' => $data->meta_keywords ?? '',
            'meta_og_image' => $data->meta_og_image ?? '',
            'meta_og_alt' => $data->meta_og_alt ?? '',
            'image_alt' => $data->image_alt ?? '',
        ];
    }

    private function storeValueByKey($key, $request)
    {
        $ogImagePath = $request->meta_og_image ?? null;

        if ($request->hasFile('meta_og_image')) {
            $file = $request->file('meta_og_image');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = public_path('frontend/images/keyValue');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $file->move($path, $filename);

            // Correctly store the relative path as string
            $ogImagePath = '/frontend/images/keyValue/' . $filename;
        }

        $data = KeyValueSetting::where('key', $key);

        $fields = [
            'value' => $request->value,
            'meta_title' => $request->meta_title ?? null,
            'meta_description' => $request->meta_description ?? null,
            'meta_keywords' => $request->meta_keywords ?? null,
            'meta_og_image' => $ogImagePath,
            'meta_og_alt' => $request->meta_og_alt ?? null,
        ];

        if ($data->exists()) {
            $data->update($fields);
        } else {
            KeyValueSetting::create(array_merge(['key' => $key], $fields));
        }

        return;
    }

}
