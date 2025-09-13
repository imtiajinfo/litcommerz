<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeyValueSetting;

class FaqController extends Controller
{
    public function index()
    {
        $about = KeyValueSetting::where('key', 'faq')->first();

        if ($about) {
            $data            = $about->value;
            $meta_title      = $about->meta_title;
            $meta_description= $about->meta_description;
            $meta_keywords   = $about->meta_keywords;
            $meta_og_image   = $about->meta_og_image;
            $meta_og_alt     = $about->meta_og_alt;
        } else {
            $data = $meta_title = $meta_description = $meta_keywords = $meta_og_image = $meta_og_alt = '';
        }

        return view('web.faq.index', compact(
            'data',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_og_image',
            'meta_og_alt'
        ));
    }
}
