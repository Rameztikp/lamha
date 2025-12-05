<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // جلب الفنادق
        $hotels = Hotel::all();

        // Check if we should show profile settings
        $showProfileSettings = $request->has('settings') && Auth::check();

        $user = null;
        if ($showProfileSettings) {
            $user = Auth::user();
            // Ensure user has required attributes, set defaults if missing
            if (!$user->phone) $user->phone = '';
            if (!$user->address) $user->address = '';
            if (!$user->gender) $user->gender = 'male';
        }

        return view('landing', [
            'hotels' => $hotels,
            'showProfileSettings' => $showProfileSettings,
            'user' => $user,
        ]);
    }
}
