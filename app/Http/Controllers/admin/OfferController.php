<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Product;
use Validator;
use Str;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['offers'] = Offer::orderBy('sl', 'asc')
            ->where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);
        

        return view('admin.offer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'offer_name' => 'required|unique:offers,name',
            'image'     => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date'   => ['required', 'date', 'after:start_date'],
            'status'     => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('offer_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/offer/'), $imageName);
            }

            $baseSlug = Str::slug($request->offer_name);
            $slug = $baseSlug;
            while (Offer::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . Str::random(5);
            }

            $offer = new Offer();
            $offer->name = $request->offer_name;
            $offer->slug = $slug;
            $offer->banner      = $imageName;
            $offer->start_date = $request->start_date;
            $offer->end_date   = $request->end_date;
            $offer->home_show     = $request->home_show;
            $offer->status     = $request->status;
            $offer->save();

            return response()->json(['success' => true, 'mgs' => 'Offer Successfully Created']);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['offer'] = Offer::findOrFail($id);
        $data['products'] = Product::all();
        return view('admin.offer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'offer_name' => 'required|unique:offers,name,'.$id,
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
            'status'     => 'required',
        ]);

        if($request->image){
            $validator =  Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=600,height=600',
            ]);
        }

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('offer_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/offer/'), $imageName);
            }

            $offer = Offer::findOrFail($id);
            if($request->image){
                if($offer->banner){
                    @unlink('frontend/images/offer/'.$offer->banner);
                }
                $offer->banner = $imageName;
            }

            $baseSlug = Str::slug($request->offer_name);
            $slug = $baseSlug;
            $count = 1;
            while (Offer::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $offer->slug = $slug;

            $offer->name       = $request->offer_name;
            $offer->start_date = $request->start_date;
            $offer->end_date   = $request->end_date;
            $offer->home_show     = $request->home_show;
            $offer->status     = $request->status;
            $offer->save();

            return response()->json(['success' => true, 'mgs' => 'Offer Successfully Updated']);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            $offer = Offer::find($id);
            if($offer->banner){
                @unlink('frontend/images/offer/'.$offer->banner);
            }
            Offer::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Offer Successfully Deleted']);
        }
    }

    public function offer_sorting(Request $request){
        if($request->type == 'store'){

            if(isset($request->offer_ids)){
                foreach ($request->offer_ids as $key => $id) {
                    Offer::find($id)->update(['sl'=>$key+1]);
                }
            }
            return response()->json(['success' => true, 'mgs' => 'Offer Successfully Sorted']);

        }else{
            $data['offers'] = Offer::orderBy('sl', 'asc')->get();
            return view('admin.offer.sorting', $data);
        }
    }
}
