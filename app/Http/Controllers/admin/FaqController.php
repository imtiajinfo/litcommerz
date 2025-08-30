<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Setting;
use Str;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.faq.index', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'faq'     => 'required',
        ]);
        
        if ($validator->passes()) {
            Setting::find(1)->update([
                'faq' => $request->faq
            ]);

            return response()->json(['success' => true, 'mgs' => 'FAQ Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

   
}
