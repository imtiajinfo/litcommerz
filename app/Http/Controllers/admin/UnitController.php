<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Unit;
use Str;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? null;

        $data['units'] = Unit::orderBy('units.id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('units.unit_name', 'like', '%'.$search.'%');
            })
            ->select('units.*')
            ->paginate($perpage);

        return view('admin.unit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'unit_name' => 'required|unique:units',
            'short_name' => 'required',
        ]);

        if ($validator->passes()) {

            $unit = new Unit();
            $unit->unit_name = $request->unit_name;
            $unit->short_name = $request->short_name;
            $unit->save();

            return response()->json(['success' => true, 'mgs' => 'Unit Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['unit'] = Unit::findOrFail($id);
        return view('admin.unit.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'unit_name' => 'required',
            'short_name' => 'required',
        ]);

        if ($validator->passes()) {

            $unit = unit::findOrFail($id);
            $unit->unit_name = $request->unit_name;
            $unit->short_name = $request->short_name;
            $unit->save();

            return response()->json(['success' => true, 'mgs' => 'Unit Successfully Updated']);
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
            Unit::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Unit Successfully Deleted']);
        }
    }
}
