<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashController extends Controller
{
    // Show Dashboard
    public function index()
    {
        return view('Userdashboard.dashboard');
    }

    
}
