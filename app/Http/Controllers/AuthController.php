<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function auth()
    {
        return view('layout.auth.app');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();

        User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);

        return response()->json(['msg' => 'Registered Successfully']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();
    
        $user = User::where('email', $data['email'])->first();
    
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return $user->createToken($data['device_name'])->plainTextToken;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    
        return response()->json(['msg' => 'Logged out successfully']);
    }
}
