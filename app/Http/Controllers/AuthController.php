<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\signUpRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signUp(signUpRequest $request)
    {

        // ($request->validated([
        //     'name'=
        // ]));
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'picture' => env('AVATAR_GENERATE_URL') . $validated['name']
        ]);

        $token = auth()->login($user);

        if (!$token) {
            return response()->json([
                'meta' => [
                    'data' => 500,
                    'status' => 'erorr',
                    'message' => 'Cannot add user',
                ],
                'Data' => [],
            ], 500);
        }
        return response()->json([
            'meta' => [
                'data' => 200,
                'status' => 'success',
                'message' => 'User created succesfully',
            ],
            'Data' => [
                'user' => [
                    'email' => $user->email,
                    'nama' => $user->name,
                    'picture' => $user->picture
                ],
                'access Token' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL() . 'minutes'),
                ]
            ],
        ], 200);
    }
}
