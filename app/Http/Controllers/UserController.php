<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $user;
    }

    public function login(Request $request){

        $user = User::where('email',$request->email)->first();

        if(Hash::check($request->password, $user->password))
            return $user;
    }
}
