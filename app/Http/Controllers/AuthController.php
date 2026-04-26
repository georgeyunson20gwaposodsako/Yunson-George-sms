<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- WEB ROUTES ---

    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validate the input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt to log the user in
        if (Auth::attempt($credentials, $request->has('remember'))) {
            
            // Security best practice: reset their session after logging in
            $request->session()->regenerate();

            // 3. Check their role and send them to the correct dashboard
            $role = strtolower((string) (Auth::user()->role ?? 'applicant'));
            
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'secretary') {
                return redirect()->intended('/secretary/dashboard');
            } else {
                // If they are an applicant/student
                return redirect()->route('applicant.form'); 
            }
        }

        // 4. IF LOGIN FAILS: Send them back to the login page with an error message
        return back()->withErrors([
            'email' => 'Incorrect email or password. Please try again.',
        ])->onlyInput('email'); 
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        // 1. Check that they filled out the form correctly
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Create the new user in the database
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'applicant', // Automatically assigning them the applicant role
        ]);

        // 3. Log the new user in immediately
        Auth::login($user);

        // 4. Send them to the applicant landing page/form
        return redirect()->route('applicant.form')->with('success', 'Registration successful! Welcome to the system.');
    }


    // --- API ROUTES ---

    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function apiRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['nullable', 'in:admin,secretary,applicant,student'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'applicant',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}