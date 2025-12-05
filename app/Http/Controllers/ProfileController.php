<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Debug: Check if user is authenticated and has data
        if (!$user) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // Ensure user has required attributes, set defaults if missing
        if (!$user->phone) $user->phone = '';
        if (!$user->address) $user->address = '';
        if (!$user->gender) $user->gender = 'male';

        return view('profile.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'in:male,female'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'different:current_password'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        $user->gender = $validated['gender'];

        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الملف الشخصي بنجاح'
            ]);
        }

        // Check if the request came from the home page settings
        if ($request->has('from_home')) {
            return redirect()->route('home', ['settings' => '1'])
                ->with('success', 'تم تحديث الملف الشخصي بنجاح');
        }

        return redirect()->route('profile.settings')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}
