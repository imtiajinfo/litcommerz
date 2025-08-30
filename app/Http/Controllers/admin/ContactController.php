<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        $data['contacts'] = Contact::orderBy('status', 'asc')->get();
        return view('admin.contact.index', $data);
    }

    public function markAsRead(Request $request)
    {
        $request->validate(['id' => 'required|exists:contacts,id']);

        Contact::where('id', $request->id)->update(['status' => 1]);
        return response()->json(['success' => true, 'mgs' => 'Marked as read']);
    }
}
