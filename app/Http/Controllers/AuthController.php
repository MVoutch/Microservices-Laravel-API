<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $scope = $request->input('scope');

            $token = $user->createToken($scope, [$scope])->accessToken;
            if($user->isCommon() && $scope !== 'common') {
                return response([
                    'error' => 'Access denied!',
                ], 403);
            }
            $cookie = cookie('logToken', $token, 3600);

            return response([
                'token' => $token
            ])->withCookie($cookie);

        }

        return response([
            'error' => 'Invalid Credentials'
        ], 401);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only("first_name", "last_name", "email") + [
                'password' => Hash::make($request->input('password')),
                'is_common' => 1
            ]);

        return response($user, 201);
    }

    public function logout()
    {
        $cookie = Cookie::forget('logToken');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);

    }


}
