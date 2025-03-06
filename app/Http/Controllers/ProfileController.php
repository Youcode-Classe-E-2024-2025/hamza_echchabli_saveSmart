<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
   
    public function index()
{
    $profiles = Auth::user()->profiles()->where('archive', 1)->get();

    return view('profiles.all', compact('profiles'));
}



public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image
    ]);

    // return $request ;

    $avatarPath = null;
if ($request->hasFile('avatar')) {
    
    $avatarPath = $request->file('avatar')->store('avatars', 'public'); 
}


    $userId = auth()->user()->id;
    // return $userId ;

    $profile = Profile::create([
        'user_id' => $userId, 
        'name' => $request->name,
        'avatar' => $avatarPath, 
        
    ]);

    return redirect('/profiles');
   
}


   

// public function login(Request $request)
//     {
//         return 'test';
//         // Validate input
//         $request->validate([
//             'profile_id' => 'required|exists:profiles,id',
           
//         ]);

//         // Retrieve the profile from the database
//         $profile = Profile::find($request->profile_id);
//         return $profile;
//         // Check if the profile exists and the password is correct
//         // if ($profile) {
//         //     // Store profile ID in session
//         //     session(['profile_id' => $profile->id]);

//         //     // Redirect to dashboard or other page
//         //     return redirect()->route('dashboard'); // Replace with your actual route
//         // }

//         // // If password is incorrect, return back with an error
//         // return back()->withErrors(['password' => 'Incorrect password.']);
//     }


}