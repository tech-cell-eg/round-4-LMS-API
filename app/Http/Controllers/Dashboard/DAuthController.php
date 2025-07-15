<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('instructor.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:instructors,email',
            'password' => 'required',
        ]);

        $instructor = Instructor::where('email', $request->email)->first();

        if ($instructor && Hash::check($request->password, $instructor->password)) {
            Auth::guard('instructor')->login($instructor);

           
            return redirect()->route('instructor.dashboard');

        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login.form');
    }
}
