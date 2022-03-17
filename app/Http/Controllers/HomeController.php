<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        /*$record = Record::whereEmail(Auth::user()->email)->first();
        Auth::user()->generateCode();*/
        return view('home');
    }
}
