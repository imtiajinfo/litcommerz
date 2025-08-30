<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use Validator;
use Str;

class RegionController extends Controller
{
    public function index(Request $request)
    {
      
        $search = $request->search ?? '';
        $data['regions'] = Region::where('name', 'like', '%'.$search.'%')
                            ->orderBy('id', 'desc')
                            ->get();
        $data['search'] = $search;
        return view('admin.region.index', $data);
    }

    public function create()
    {
        return view('admin.region.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:regions',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        if ($validator->passes()) {
            Region::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'delivery_charge' => $request->delivery_charge,
            ]);

            return response()->json(['success' => true, 'mgs' => 'Region Created']);
        } else {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }
    }

    public function edit($id)
    {
        $data['region'] = Region::findOrFail($id);
        return view('admin.region.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:regions,name,' . $id,
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        if ($validator->passes()) {
            $region = Region::findOrFail($id);
            $region->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'delivery_charge' => $request->delivery_charge,
            ]);

            return response()->json(['success' => true, 'mgs' => 'Region Updated']);
        } else {
            return response()->json(['error' => true, 'errors' => $validator->errors()]);
        }
    }

    public function destroy($id)
    {
        Region::find($id)->delete();
        return response()->json(['success' => true, 'mgs' => 'Region Deleted']);
    }
}
