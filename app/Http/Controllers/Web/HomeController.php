<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Property; 

class HomeController extends Controller
{
   
    public function index()
    {
        $user = session('user');
        $message = session('message');
        
        $users = User::all();
        
        $properties = Property::all();
        
        $propertyDealers = User::where('role', 'property_dealer')->get();
        
        return view('dashboard', [
            'user' => $user,
            'message' => $message,
            'users' => $users,
            'properties' => $properties,
            'propertyDealers' => $propertyDealers,
        ]);
    }
    
    




    public function profile()
    {
        return view('profile');
    }

    
}
