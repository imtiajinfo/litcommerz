<?php

namespace App\View\Components\web;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class aside_auth extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $mgs = "hello world";
        return view('components.web.aside_auth', compact('mgs'));
    }
}
