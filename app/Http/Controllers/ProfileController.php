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


   



}