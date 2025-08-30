<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Mail;
use Hash;
use App\Mail\RegistrationMail;
use App\Mail\FogetMailVerify;
use Throwable;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function loginAction(Request $request){
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if ($user && $user->status == 2) {
            if (empty($user->block_until)) {
                return redirect()->back()->withErrors([
                    'error' => "Your account is blocked. Please contact support."
                ]);
            }

            $blockUntil = \Illuminate\Support\Facades\Date::parse($user->block_until);

            if ($blockUntil->isFuture()) {
                return redirect()->back()->withErrors([
                    'error' => "Your account is blocked until " . $blockUntil->format('d-m-Y') . "."
                ]);
            }

            if ($user->block_until && ($blockUntil->isToday() || $blockUntil->isPast())) {
                $user->status = 1;
                $user->block_until = null;
                $user->save();
            }
        }

        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1, 'verified' => 1])) {
            if(Auth::user()->type == 2){
                return redirect('admin-panel');
            } else {
                if(session()->get('redirectUrl')){
                    $url = session()->get('redirectUrl');
                    session()->forget('redirectUrl');
                    return redirect($url);
                }
                return redirect('/');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Credentials Not Matched!']);
        }
    }

    public function webcheckoutloginAction(Request $request){
        $validated = $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;
 
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1, 'verified' => 1])) {
            if(session()->get('redirectUrl')){
                $url = session()->get('redirectUrl');
                session()->forget('redirectUrl');
                return redirect($url);
            }
            return redirect()->back();
        }else{
            return redirect()->back()->with(['error' => true,'mgs' => 'Credentials Not Matched!']);
        }
    }

    public function webloginAction(Request $request){
        $validated = $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;
 
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1, 'verified' => 1])) {
            if(Auth::user()->type == 2){
                return response()->json(['success'=>1, 'type'=>2]);
            }else{
                return response()->json(['success'=>1, 'type'=>1]);
            }
        }else{
            return response()->json(['type'=>1, 'error' => 1,'mgs'=> 'Credentials Not Matched!']);
        }
    }

    public function register(){
        return view('admin.auth.register');
    }

    public function registerAction(Request $request){
        
        $validator = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'min:6',
            'confirmed' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator) {
            $token = uniqid();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_code' => $token,
                'verified'=>1
            ]);
            Auth::loginUsingId($user->id);
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'remember_token' => $token
            ];
 
            // Mail::to($request->email)->send(new RegistrationMail($data));

            return response()->json(['success' => true, 'mgs' => 'Registration Successfully']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
    public function adminRegisterAction(Request $request){
        
        $validator = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'min:6',
            'confirmed' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator) {
            $token = uniqid();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_code' => $token,
                'verified'=>1
            ]);

            Auth::loginUsingId($user->id);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'remember_token' => $token
            ];
 
            // Mail::to($request->email)->send(new RegistrationMail($data));

            // return redirect('/verify-your-mail')->with(['success' => true, 'mgs' => 'Registration Successfully']);
            if(session()->get('redirectUrl')){
                $url = session()->get('redirectUrl');
                session()->forget('redirectUrl');
                return redirect($url);
            }
            return redirect('/')->with(['success' => true, 'mgs' => 'Registration Successfully']);

        }else{
            return redirect()->back()->with(['error' => true, $validator->errors()]);
        }
    }

    public function registerCheckoutAction(Request $request){
        
        $validator = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'min:6',
            'confirmed' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator) {
            $token = uniqid();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_code' => $token,
                'verified'=>1
            ]);

            Auth::loginUsingId($user->id);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'remember_token' => $token
            ];
 
            // Mail::to($request->email)->send(new RegistrationMail($data));

            // return redirect('/verify-your-mail')->with(['success' => true, 'mgs' => 'Registration Successfully']);
            if(session()->get('redirectUrl')){
                $url = session()->get('redirectUrl');
                session()->forget('redirectUrl');
                return redirect($url);
            }
            return redirect()->back()->with(['success' => true, 'mgs' => 'Registration Successfully']);

        }else{
            return redirect()->back()->with(['error' => true, $validator->errors()]);
        }
    }
    

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('/login');
    }

    public function verify_your_email(){
        return view('web.verify_your_mail');
    }
    public function verify_email($verification_code){
        if($verification_code){
            $user = User::where('verification_code', $verification_code)->where('verified', '!=', 1)->first();
            if($user){
                User::where('verification_code', $verification_code)->where('verified', '!=', 1)->update(['verified'=>1, 'verification_code'=>'']);
                Auth::loginUsingId($user->id);

                if(session()->get('redirectUrl')){
                    $url = session()->get('redirectUrl');
                    session()->forget('redirectUrl');
                    return redirect($url);
                }
                return redirect('/')->with(['success' => 1, 'mgs' =>'Verification Successfully']);
            }
        }
        return response('Your Verification Code is not Valid!');
    }

    public function lost_password(){
        return view('admin.auth.lost_password');
    }
    public function lost_password_verify_code(Request $request){
        $validator = $request->validate([
            'email' => 'required',
        ]);

        if ($validator) {
            $token = uniqid();
            $user = User::where('email', $request->email);

            if($user->exists()){
                $user->update(['verification_code' => $token]);
                
                $data = [
                    'name' => $user->first()->name,
                    'email' => $user->first()->email,
                    'token' => $token
                ];
                try {
                    Mail::to($request->email)->send(new FogetMailVerify($data));
                } catch (\Throwable $th) {
                    return redirect()->back()->with(['error' => true, 'mgs'=>'Something Went Wrong! Please Try Again Letter!']);
                }

                return view('admin.auth.lost_password_verify');
            }else{
                return redirect()->back()->with(['error' => true, 'mgs'=>'Wrong Email. Please Enter Right Email!']);
            }

        }else{
            return redirect()->back()->with(['error' => true, $validator->errors()]);
        }
    }

    public function lost_password_token($token){
        $user = User::where('verification_code', $token)->first();
        if(empty($user)){
            return redirect()->back()->with(['error' => true, 'mgs'=>'Your Verification Code Not Correct! Please Try Again!']);
        }

        return view('admin.auth.lost_password_change', compact('token'));
    }
    public function lost_password_token_post(Request $request){
        $validator = $request->validate([
            'password' => 'min:6',
            'confirmed' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator) {
            $user = User::where('verification_code', $request->token)->first();
            if(empty($user)){
                return redirect()->back()->with(['error' => true, 'mgs'=>'Your Verification Code Not Correct! Please Try Again!']);
            }

            $user->update([
                'password'=>Hash::make($request->password)
            ]);

            Auth::loginUsingId($user->id);

            return redirect('/')->with(['success' => 1, 'mgs' =>'Password Updated Successfully']);

        }else{
            return redirect()->back()->with(['error' => true, $validator->errors()]);
        }
    }
}
