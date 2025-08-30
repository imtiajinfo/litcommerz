<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeyValueSetting;

class TermConditionController extends Controller
{
    public function index(){
        $value = KeyValueSetting::where('key', 'terms_and_conditions')->first();
        if(!empty($value)){
            $data = $value->value;
        }else{
            $data = '';
        }
        return view('web.terms_conditions.index', compact('data'));
    }
}
