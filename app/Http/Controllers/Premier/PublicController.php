<?php

namespace App\Http\Controllers\Premier;

use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function index()
    {
        return view('public.public.index');
    }
}
