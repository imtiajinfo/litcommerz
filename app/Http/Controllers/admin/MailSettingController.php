<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailConfiguration;
use Validator;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mail = EmailConfiguration::first();
        return view('admin.setting.email_setting', compact('mail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mail = EmailConfiguration::first();
        if($request->status == 1){
            if(!empty($mail)){
                try {
                    Mail::raw('Test email mydailyshop', function ($message) {
                        $message->to('akash904069@gmail.com')->subject('Test Email mydailyshop');
                    });
                    return response()->json(['success' => true, 'mgs' => 'Email Configuration is ok']);

                } catch (\Exception $e) {
                    return response()->json(['error' => true, 'mgs'=>'Email Configuration is Not ok!']);
                }
            }else{
                return response()->json(['error' => true, 'mgs'=>'Email Configuration is Not ok!']);
            }
        }

        $validator =  Validator::make($request->all(), [
            'driver'     => 'required',
            'host'       => 'required',
            'port'       => 'required',
            'username'   => 'required',
            'password'   => 'required',
            'encryption' => 'required'
        ]);

        if ($validator->passes()) {

            if (!empty($mail)) {
                $mail->update($request->all());
            } else {
                EmailConfiguration::create($request->all());
            }

            return response()->json(['success' => true, 'mgs' => 'Mail Configuration Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

}
