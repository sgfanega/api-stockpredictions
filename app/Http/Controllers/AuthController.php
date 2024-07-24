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
     * Delete Method
     * 
     * @param string $email
     * 
     * @return \Illuminate\Http\Response
     */
    // public function destroy(string $email)
    // {
    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'User not found.'], 404);
    //     }

    //     Auth::logout();

    //     $user->delete();

    //     return response($email . ' User Deleted.', 200);
    // }
}
