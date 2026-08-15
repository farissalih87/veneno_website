<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    /**
     * Show login page.
     */
    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Authenticate user.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasAnyRole(['super_admin', 'manager', 'technician', 'receptionist'])) {
                return redirect()->intended(route('dashboard'));
            }

            return redirect()->intended(route('customer.portal'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Quick Demo Switcher login (Super Admin, Manager, Technician, Customer).
     */
    public function quickLogin(Request $request, string $role)
    {
        $emailMap = [
            'admin' => 'admin@venenoautocare.com',
            'manager' => 'manager@venenoautocare.com',
            'technician' => 'marcus@venenoautocare.com',
            'customer' => 'alex@example.com',
        ];

        $email = $emailMap[$role] ?? 'admin@venenoautocare.com';
        $user = User::where('email', $email)->firstOrFail();

        Auth::login($user);
        $request->session()->regenerate();

        if ($role === 'customer') {
            return redirect()->route('customer.portal');
        } elseif ($role === 'technician') {
            return redirect()->route('technician.portal');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Register customer.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:50',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'loyalty_tier' => 'Silver',
            'loyalty_points' => 100, // Welcome bonus
        ]);

        $user->assignRole('customer');

        Auth::login($user);

        return redirect()->route('customer.portal');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
