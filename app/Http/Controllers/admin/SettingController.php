<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Setting;
use App\Models\Role;
use Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email'     => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'free_shipping_limit'   => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('logo')){ 
                $validator =  Validator::make($request->all(), [
                    'logo'      => 'required|image|mimes: jpeg,png,jpg',
                ]);
                $logoName = 'logo-'.date('d.m.Y.h.s').'.'.$request->logo->extension();  
                $request->logo->move(public_path('frontend/logo/'), $logoName);
            }
            if($request->hasfile('meta_logo')){ 
                $validator =  Validator::make($request->all(), [
                    'meta_logo' => 'required|image|mimes: jpeg,png,jpg',
                ]);
                $meta_logoName = 'meta_logo-'.date('d.m.Y.h.s').'.'.$request->meta_logo->extension();  
                $request->meta_logo->move(public_path('frontend/logo/'), $meta_logoName);
            }

            $setting = Setting::find($request->id);
            $setting->email     = $request->email;
            $setting->phone     = $request->phone;
            $setting->facebook  = $request->facebook;
            $setting->twitter   = $request->twitter;
            $setting->linkedin  = $request->linkedin;
            $setting->whatsapp = $request->whats_app;
            $setting->address   = $request->address;
            $setting->currency_icon   = $request->currency_icon;
            $setting->free_shipping_limit   = $request->free_shipping_limit;
            if($request->logo){
                $setting->logo = $logoName;
            }
            if($request->meta_logo){
                $setting->meta_logo = $meta_logoName;
            }
            $setting->save();

            return response()->json(['success' => true, 'mgs' => 'Setting Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    public function seoSettings()
    {
        $settings = Setting::firstOrNew();

        return view('admin.settings.seo', $settings->toArray());
    }

    public function seoSettingsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=1200,height=630',
            'meta_og_alt' => 'nullable|string',
            'google_analytics' => 'nullable|string',
            'google_tag_manager' => 'nullable|string',
            'facebook_pixel' => 'nullable|string',
            'google_site_verification' => 'nullable|string',
            'bing_site_verification' => 'nullable|string',
            'yandex_site_verification' => 'nullable|string',
            'default_twitter_card' => 'nullable|string',
            'default_schema_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $settings = Setting::firstOrNew();

        // Handle OG image upload
        if ($request->hasFile('meta_og_image')) {
            $file = $request->file('meta_og_image');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = public_path('frontend/images/settings');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $file->move($path, $filename);
            $settings->meta_og_image = '/frontend/images/settings/' . $filename;
        }

        $fields = [
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_og_alt',
            'google_analytics',
            'google_tag_manager',
            'facebook_pixel',
            'google_site_verification',
            'bing_site_verification',
            'yandex_site_verification',
            'default_twitter_card',
            'default_schema_type'
        ];

        foreach ($fields as $field) {
            $settings->$field = $request->$field ?? null;
        }

        $settings->save();

        return response()->json(['success' => true, 'mgs' => 'Setting Successfully Updated']);
    }

    
}
