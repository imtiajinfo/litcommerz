<?php

namespace App\View\Components\web;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\Setting;

class header_sidebar extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        dd(121);
        $setting_header_sidebar = Setting::find(1);
        return view('components.web.header_sidebar', compact('setting_header_sidebar'));
    }
}
