<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('pages.auth.login');
    }

    public function registerView()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        return response()->json([
            'success' => true,
            'message' => 'User baru berhasil ditambahkan.'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token-name')->plainTextToken;
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => 'Login berhasil.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password tidak valid.'
        ], 404);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Auth::user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'logout success'
        ]);
    }
}
