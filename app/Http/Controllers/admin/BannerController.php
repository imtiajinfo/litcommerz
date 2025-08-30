<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['banners'] = Banner::orderBy('id', 'desc')
            ->paginate($perpage);
        
        return view('admin.banner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    public function edit(string $id)
    {
        $data['banner'] = Banner::findOrFail($id);
        return view('admin.banner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'type' => 'required',
            'link' => 'required',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                if($request->type ==1){
                    $validator =  Validator::make($request->all(), [
                        'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=1500,height=234',
                    ]);
                }elseif($request->type==2){
                    $validator =  Validator::make($request->all(), [
                        'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=1000,height=510',
                    ]);
                }
                $imageName = date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/banner/'), $imageName);
                
            }

            $banner = Banner::findOrFail($id);
            if($request->hasfile('image')){ 
                if($banner->image){
                    @unlink('frontend/images/banner/'.$banner->image);
                }
                $banner->image = $imageName;
            }
            $banner->status = $request->status;
            $banner->link = $request->link;
            $banner->type = $request->type;
            $banner->save();

            return response()->json(['success' => true, 'mgs' => 'Banner Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'type' => 'required',
            'link' => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=1500,height=234',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/banner/'), $imageName);
            }

            $banner = new Banner();
            $banner->image = $imageName;
            $banner->status = $request->status;
            $banner->link = $request->link;
            $banner->type = $request->type;
            $banner->save();

            return response()->json(['success' => true, 'mgs' => 'Banner Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            Banner::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Banner Successfully Deleted']);
        }
    }
}
