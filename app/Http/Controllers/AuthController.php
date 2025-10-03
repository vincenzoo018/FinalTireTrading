<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();

            // ✅ Redirect based on role
            if ($user->role_id == 1 || $user->role_id == 2) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == 3) {
                return redirect()->route('customer.home');
            }
        }

        return back()->withErrors(['login_error' => 'Invalid credentials']);
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ✅ Handle registration (customer only)
    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role_id' => 3, // ✅ default: customer
            'is_active' => true,
        ]);

        // ✅ Automatically log in after registration
        Auth::login($user);

        return redirect()->route('auth.login')->with('success', 'Registration successful! Welcome!');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}