<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        return view('web.contact.index');
    }
    public function store(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }else{

            $validator =  Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'subject'   => 'required|string|max:255',
                'text'      => 'required|string|max:255',
            ]);

            $data = $request->all();

            $data['user_id'] = Auth::id();
            
            if ($validator->passes()) {

                Contact::create($data);

                return redirect()->back()->with(['success' => 1, 'mgs' => 'Message Send Successfully']);
            }else{
                return redirect()->back()->with([$validator->errors()]);
            }

        }
    }
}
