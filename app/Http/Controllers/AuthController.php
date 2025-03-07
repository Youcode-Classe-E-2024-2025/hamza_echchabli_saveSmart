<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;

use App\Models\Balance;

class AuthController extends Controller
{
    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->intended('/dashboard'); 
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // public function register(Request $request)
    // {

    //     // return $request;
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);
    
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'monthly_income'=> $request->monthly_income,
    //         'balance'=>$request->monthly_income,
          
    //     ]);
    
       
    
    //     Profile::create([
    //         'user_id' => $user->id,
    //         'name' => $user->name,
    //         'password' => Hash::make('defaultpassword'),
    //         'avatar' => '',
    //     ]);
        
    //       Auth::login($user);

    //     return redirect('/profiles');
    // }



public function register(Request $request)
{

    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'monthly_income' => 'required|numeric|min:0',
    ]);

    

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'monthly_income' => $request->monthly_income, // Keep monthly income
    ]);


    

    // Distribute balance (50% Needs, 30% Wants, 20% Savings)
    $b =Balance::create([
        'user_id' => $user->id,
        'needs' => $request->monthly_income * 0.50,
        'wants' => $request->monthly_income * 0.30,
        'savings' => $request->monthly_income * 0.20,
    ]);

    // return $b;

    Profile::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'password' => Hash::make('defaultpassword'),
        'avatar' => '',
    ]);

    Auth::login($user);

    return redirect('/profiles');
}



}