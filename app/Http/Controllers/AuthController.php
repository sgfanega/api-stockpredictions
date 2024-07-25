<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use HttpResponses;

    /**
     * Login Method
     * 
     * @param \App\Http\Request\LoginUserRequest
     * @return \App\Traits\HttpResponse
     */
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->fail('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => [
                $user->name,
                $user->email
            ],
            'token' => $user->createToken('API Token')->plainTextToken
        ], 'Do not share your tokens!');

    }

    /**
     * Register Method
     * 
     * @param \App\Http\Requests\StoreUserRequest
     * @return \App\Traits\HttpResponse
     */
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->only(['name', 'email', 'password']));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ], 'Welcome to the Stock Prediction Club');
    }

    /**
     * Logout Method
     * 
     * @return \App\Traits\HttpResponse
     */
    public function logout()
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have successfully logged out of the Stock Predictor API, and your token is deleted and unusable.'            
        ]);
    }
}
