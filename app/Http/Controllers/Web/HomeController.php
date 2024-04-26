<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Property; 
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
   
    public function index()
    {
        $user = session('user');
        $message = session('message');
        
        $users = User::all();
        
        $properties = Property::all();
        $activeUsersCount = User::where('status', true)->count();
        $inactiveUsersCount = User::where('status', false)->count();
        $propertyDealers = User::where('role', 'property_dealer')->get();
        
        return view('dashboard', [
            'user' => $user,
            'message' => $message,
            'users' => $users,
            'properties' => $properties,
            'propertyDealers' => $propertyDealers,
            'activeUsersCount' => $activeUsersCount,
            'inactiveUsersCount' => $inactiveUsersCount,
        ]);
    }
    
    




    public function profile()
    {
        return view('profile');
    }



// apk download file function



public function downloadApk()
{
    $apkDirectory = public_path('apk');

    $apkFiles = File::glob($apkDirectory . '/*.apk');
    // Check if any APK file exists
    if (empty($apkFiles)) {
        abort(404, 'No APK files found');
    }

    // Get the first APK file found
    $apkFilePath = $apkFiles[0];

    // Provide download response
    return response()->download($apkFilePath, 'app-release.apk');
}

    
}
