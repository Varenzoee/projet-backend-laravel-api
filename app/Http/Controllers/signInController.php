<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class signInController extends Controller
{
    public function signIn (Request $request){


        $token = auth()->attempt($request->all()

    );
    }
}
