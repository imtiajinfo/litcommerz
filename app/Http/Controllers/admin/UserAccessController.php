<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Role;
use Str;
use Illuminate\Support\Facades\Hash;

class UserAccessController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';

        $data['users'] = User::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.user.list', $data);
    }

    public function create()
    {
        $data['roles'] = Role::latest()->get();
        return view('admin.user.create', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'   => true,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->status = 1;
        $user->verified = 1;
        $user->save();

        return response()->json(['success' => true, 'mgs' => 'User Successfully Created']);
    }

    public function edit(Request $request)
    {
        $data['roles'] = Role::all();
        $data['user'] = User::findOrFail($request->user_id);
        return view('admin.user.role', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'role' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
            'block_until' => 'nullable|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }

        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        if ($request->status == 2) {
            $user->block_until = $request->block_until;
        } else {
            $user->block_until = null;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->status = 1;
        $user->verified = 1;
        $user->save();

        return response()->json(['success' => true, 'mgs' => 'User Successfully Updated']);
    }

    public function details(Request $request){
        $user = User::findOrFail($request->user_id);

        return view('admin.user.details', compact('user'));
    }

    public function orders(Request $request){

        $data['orders'] = Order::orderBy('id', 'desc')
            ->where('user_id', $request->user_id)
            ->get();

        return view('admin.user.orders', $data);
    }

    public function password(Request $request)
    {
        $data['user_id'] = $userId = $request->user_id;
        return view('admin.user.password', $data);
    }

    public function change_password(Request $request){
        $validator =  Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required | min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->passes()) {

            $user = User::find($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['success' => true, 'mgs' => 'Password Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'mgs' => 'Deleted Successfully']);
    }

}
