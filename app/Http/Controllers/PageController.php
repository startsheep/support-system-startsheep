<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('guest');
    }

    public function admin()
    {
        MessageCreated::dispatch("Hello World");
        return "OK";
        // return view('app');
    }

    public function auth()
    {
        return view('auth');
    }
}
