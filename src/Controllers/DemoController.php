<?php

namespace Samsquid\LaravelFilemanager\Controllers;

class DemoController extends LfmController
{
    public function index()
    {
        return view('laravel-filemanager::demo');
    }
}
