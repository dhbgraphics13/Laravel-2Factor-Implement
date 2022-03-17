<?php

namespace App\Models;


use App\Mail\TwoFactorOtp;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Exception;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateCode()
    {

        $code = encrypt(rand(1000000, 9999));


        TwoFactor::updateOrCreate(
            [ 'user_id' => Auth::user()->id ],
            [ 'code' => Hash::make(decrypt($code)) ]
        );

        $data=[
            'receiverEmailID' => auth()->user()->email,
            'message' => "2 Factor login code is ". decrypt($code),
        ];

        try {

            Mail::to($data['receiverEmailID'])->Send(new TwoFactorOtp($data));

        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }



}
