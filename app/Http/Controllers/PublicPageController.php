<?php

namespace App\Http\Controllers;

class PublicPageController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function about()
    {
        return view('public.about');
    }

    public function developers()
    {
        return view('public.developers');
    }

    public function feedback()
    {
        return view('public.feedback');
    }
}
