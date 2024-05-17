<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
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

    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $user = User::where('email', 'admin@bgroup.id')->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            Auth::login($user);
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


    // Edit Profile
    public function profileView()
    {
        return view('pages.profile');
    }

    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $user = $request->user();
        $user->update($request->except('password'));

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->input('password'))]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Edit profile berhasil diubah.'
        ]);
    }

    public function current(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user(), 'success' => true]);
    }
}
