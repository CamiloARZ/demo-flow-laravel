<?php

namespace App\Components;

use Illuminate\Support\Facades\URL;

class HtmlGenerator
{

    public function link($url = null, $name = null, $class = null)
    {
    	$url = URL::to($url, [], null);
        // si no tenemos el $name pero tenemos $url
        if (isset($url) && is_null($name)) {
            $name = $url;
        }
        return view('HtmlGenerator.link', compact('name', 'url', 'class'));
    }
}