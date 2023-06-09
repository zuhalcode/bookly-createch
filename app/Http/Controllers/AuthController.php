<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexLogin($slug)
    {
        return view('auth.login', ['slug' => $slug]);
    }

    public function indexRegister($slug)
    {
        return view('auth.register', ['slug' => $slug]);
    }

    public function loginModal(Request $req, $slug)
    {
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $company = Company::where('slug', $slug)->first();
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            if (Auth::attempt($credentials) || (Auth::check() && Auth::user()->role->name === 'super-admin')) {
                $req->session()->regenerate();
                return back();
            }

            if (!$user->companies()->where('company_id', $company->id)->exists()) {
                return back()->with('error', 'Oops! It seems you haven\'t registered on our site.');
            }
        }

        return back()->with('error', 'Oops! It seems you haven\'t registered on our site.');
    }

    public function registerModal(Request $req, $slug)
    {
        $company = Company::where('slug', $slug)->first();

        $validatedData = $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        $company->users()->attach($user->id);
        Auth::login($user);

        return back()->with('success', 'Login Berhasil!, silahkan selesaikan order anda');
    }

    public function login(Request $req, $slug)
    {
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $company = Company::where('slug', $slug)->first();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role->name === 'super-admin' || ($company && $company->users()->where('user_id', $user->id)->exists())) {
                $req->session()->regenerate();
                return redirect("/$slug");
            } else {
                Auth::logout();
                return back()->with('error', "Oops! It seems you haven't registered on our site.");
            }
        } else {
            // Wrong credentials
            return redirect("/$slug/auth/login")->with('error', 'Invalid credentials. Please check your email and password.');
        }
    }

    public function register(Request $req, $slug)
    {
        $company = Company::where('slug', $slug)->first();

        $validatedData = $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        $company->users()->attach($user->id);
        return redirect("/$slug/auth/login")->with('success', 'Registrasi berhasil! Silahkan login');
    }

    public function logout(Request $req, $slug)
    {
        Auth::logout();
        return redirect("/$slug/auth/login");
    }
}
