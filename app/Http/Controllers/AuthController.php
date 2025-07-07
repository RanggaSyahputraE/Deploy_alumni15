<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Alumni;
use App\Models\Teacher;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Redirect to appropriate dashboard based on user role.
     */
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAlumni()) {
            return redirect()->route('alumni.dashboard');
        } elseif ($user->isGuru()) {
            return redirect()->route('guru.dashboard');
        }
        return redirect('/');
    }

    /**
     * Show alumni registration form.
     */
    public function showAlumniRegistrationForm()
    {
        return view('auth.register_alumni');
    }

    /**
     * Handle alumni registration.
     */
    public function registerAlumni(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y')),
        ]);

        $alumniRole = Role::where('name', 'alumni')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $alumniRole->id,
        ]);

        Alumni::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'graduation_year' => $request->graduation_year,
        ]);

        Auth::login($user);
        $user->load('alumni'); 
        return redirect()->route('alumni.dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Show guru registration form.
     */
    public function showGuruRegistrationForm()
    {
        return view('auth.register_guru');
    }

    /**
     * Handle guru registration.
     */
    public function registerGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'nip' => 'nullable|string|unique:teachers',
        ]);

        $guruRole = Role::where('name', 'guru')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $guruRole->id,
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'nip' => $request->nip,
        ]);

        Auth::login($user);
        return redirect()->route('guru.dashboard')->with('success', 'Registrasi berhasil!');
    }
}