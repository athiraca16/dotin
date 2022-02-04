<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login user.
     *
     * @param  Login  $request
     * @return UserResource
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Login users
        if (!Auth::attempt($credentials)) {
            return validationError(['email' => [trans('auth.failed')]]);
        }
          

        // Get user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return validationError(['code' => [trans('auth.invalid_login')]]);
        }
         // Create access token
         $token = $user->createToken('token-name')
         ->plainTextToken;
         return (new UserResource($user))
         ->additional(['meta' => ['access_token' => $token]]);
 }
}
