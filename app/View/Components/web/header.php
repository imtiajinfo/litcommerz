<?php

namespace App\View\Components\web;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\Setting;

class header extends Component
{

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $setting_header = Setting::find(1);
        return view('components.web.header', compact('setting_header'));
    }
}
