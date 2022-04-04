<?php

namespace App\Http\Controllers;


use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{

    public function store(Request $request)
    {
        /*TwoFactor::updateOrCreate(
            [ 'user_id' => Auth::user()->id ],
            [ 'code' => Hash::make(decrypt($code)) ]
        );*/
    }

   }
