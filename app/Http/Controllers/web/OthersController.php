<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeyValueSetting;
use App\Models\Complain;
use Validator;

class OthersController extends Controller
{
    public function shipping_details(){
        $about = KeyValueSetting::where('key', 'shipping_details')->first();

        if ($about) {
            $data            = $about->value;
            $meta_title      = $about->meta_title;
            $meta_description= $about->meta_description;
            $meta_keywords   = $about->meta_keywords;
            $meta_og_image   = $about->meta_og_image;
            $meta_og_alt     = $about->meta_og_alt;
        } else {
            $data = $meta_title = $meta_description = $meta_keywords = $meta_og_image = $meta_og_alt = '';
        }

        return view('web.others.shipping_details', compact('data', 'meta_title', 'meta_description', 'meta_keywords', 'meta_og_image', 'meta_og_alt'));
    }
      public function physicalStore(){
          $value = $this->getValueByKey('physical_store');
          return view('admin.others.physical_store', compact('value'));
      }
    public function banner_gallery(){
        $value = KeyValueSetting::where('key', 'banner_gallery')->first();
        if(!empty($value)){
            $data = $value->value;
        }else{
            $data = '';
        }
        return view('web.others.banner_gallery', compact('data'));
    }
    public function how_to_order()
    {
        $about = KeyValueSetting::where('key', 'how_to_order')->first();

        if ($about) {
            $data            = $about->value;
            $meta_title      = $about->meta_title;
            $meta_description= $about->meta_description;
            $meta_keywords   = $about->meta_keywords;
            $meta_og_image   = $about->meta_og_image;
            $meta_og_alt     = $about->meta_og_alt;
        } else {
            $data = $meta_title = $meta_description = $meta_keywords = $meta_og_image = $meta_og_alt = '';
        }

        return view('web.others.how_to_order', compact(
            'data',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_og_image',
            'meta_og_alt'
        ));
    }
    public function privacy_policy()
    {
        $about = KeyValueSetting::where('key', 'privacy_policy')->first();

        if ($about) {
            $data            = $about->value;
            $meta_title      = $about->meta_title;
            $meta_description= $about->meta_description;
            $meta_keywords   = $about->meta_keywords;
            $meta_og_image   = $about->meta_og_image;
            $meta_og_alt     = $about->meta_og_alt;
        } else {
            $data = $meta_title = $meta_description = $meta_keywords = $meta_og_image = $meta_og_alt = '';
        }

        return view('web.terms_conditions.index', compact(
            'data',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_og_image',
            'meta_og_alt'
        ));
    }
    
    public function complain_form(){
        $value = KeyValueSetting::where('key', 'complain_form')->first();
        if(!empty($value)){
            $data = $value->value;
        }else{
            $data = '';
        }
        return view('web.others.complain_form', compact('data'));
    }
    public function complain_form_store(Request $request){
        $validator =  Validator::make($request->all(), [
            "name" => "required|max:255",
            "email" => "required|max:255",
            "order_no" => "required|max:255",
            "phone" => "required|max:255",
            "inquery" => "required|max:255",
            "message" => "max:1500"
        ]);

        if ($validator->passes()) {
            $imageName = '';
            if($request->hasfile('image')){ 
                $imageName = date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/complain-form/'), $imageName);
            }

            Complain::create([
                "name"     => $request->name,
                "email"    => $request->email,
                "order_no" => $request->order_no,
                "phone"    => $request->phone,
                "inquery"  => $request->inquery,
                "message"  => $request->message,
                "image"  => $imageName,
            ]);
            return redirect()->back()->with(['success' => true, 'mgs' => 'Complain Submitted Successfully']);

        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
