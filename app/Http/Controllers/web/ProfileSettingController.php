<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Models\UserPoint;
use App\Models\UserDetails;
use Validator;
use Str;

class ProfileSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profile = Auth::user();
        $type = $request->type;
        $points = 0;
        $user_details = [];

        switch ($type) {
            case 'dashboard':
                // dashboard start
                $points = UserPoint::where('user_id', $profile->id)->sum('point');
                // dashboard end
                break;
            case 'password':
                // password start
                // password end
                break;
            case 'profile':
                // profile start 
                $user_details = UserDetails::where('user_id', $profile->id)->first();
                // profile end
                break;
            case 'points':
                // points start 
                $points = UserPoint::where('user_id', $profile->id)->sum('point');
                // points end 
                break;
            default:
                abort(404, 'Something Went Wrong!');
                break;
        }
        

        return view('web.profile.index', compact('profile', 'type', 'points', 'user_details'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            "old_password" => "required",
            "re_password" => "required",
            "new_password" => "required|min:6",
        ]);

        if ($validator->passes()) {

            $admin_id = Auth::user()->id;
            $currentPassword = $request->old_password;
            $oldPassword = User::find($admin_id)->password;

            if(Hash::check($currentPassword, $oldPassword)){
                if($request->new_password == $request->re_password){
                    $admin_new_password = Hash::make($request->new_password);
                    User::where('id', $admin_id)->update(['password' => $admin_new_password]); 
                    return redirect()->back()->with(['success' => true, 'mgs' => 'Password Changed Successfully']);

                }else{
                    return redirect()->back()->with(['error' => 1, 'mgs' => 'New Password Re-Password Does Not not Matched']);
                }
            }else{
                return redirect()->back()->with(['error' => 1, 'mgs' => 'Old Password Does not matched']);
            }
        
        }else{
            return redirect()->back()->with(['error' => 1, $validator->errors()]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // if($request->status == 'profile'){

            $validator =  Validator::make($request->all(), [
                "name" => "required",
            ]);
            if ($validator->passes()) {
                if($request->hasfile('image')){ 
                    $imageName = Str::slug($request->input('name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                    $request->image->move(public_path('frontend/images/profile/'), $imageName);
                }
                $user = User::find(Auth::id());
                $user->name = $request->name;
                
                if($request->image){
                    $user->avatar = $imageName;
                }
                $user->save();
    
                // return redirect()->back()->with(['success' => true, 'mgs' => 'Profile Updated Successfully']);
            }else{
                return redirect()->back()->with(['error' => true, $validator->errors()]);
            }
        // }elseif($request->status == 'address'){
            $profile = UserDetails::where('user_id', Auth::id())->first();

            if(empty($profile)){

                UserDetails::create([
                    'user_id'        => Auth::id(),
                    'street_address' => $request->address,
                    'apt_suite'      => $request->apt,
                    'city'           => $request->city,
                    'post_code'      => $request->postcode,
                    'phone'          => $request->phone,
                ]);

            }else{
                UserDetails::where('user_id', Auth::id())->update([
                    'street_address' => $request->address,
                    'apt_suite'      => $request->apt,
                    'city'           => $request->city,
                    'post_code'      => $request->postcode,
                    'phone'          => $request->phone,
                ]);
            }
            return redirect()->back()->with(['success' => true, 'mgs' => 'Profile Updated Successfully']);

        // }

    }
}
