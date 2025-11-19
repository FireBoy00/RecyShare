<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Recipe;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $userRecipes = Recipe::where('user_id', Auth::id())->latest()->get();
        $userFavorites = Auth::user()->favorites()->with('recipe')->latest()->get();
        
        return view('settings', compact('userRecipes', 'userFavorites'));
    }

    /**
     * Update account settings (bio, email, password).
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->input('active_tab', 'profile');

        // Check if this is a password change request
        if ($request->has('password_change')) {
            try {
                $validated = $request->validate([
                    'current_password' => ['required'],
                    'password' => ['required', 'confirmed', 'min:8'],
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->route('settings.index', ['tab' => $activeTab])
                    ->withErrors($e->validator)
                    ->withInput();
            }

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('settings.index', ['tab' => $activeTab])
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('settings.index', ['tab' => $activeTab])->with('status', 'Password updated successfully.');
        }

        // Otherwise update profile/account information
        try {
            $data = $request->validate([
                'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'bio' => ['nullable', 'string', 'max:500'],
                'display_name' => ['nullable', 'string', 'max:255'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('settings.index', ['tab' => $activeTab])
                ->withErrors($e->validator)
                ->withInput();
        }
        
        if ($request->has('email') && !empty($data['email'])) {
            $user->email = $data['email'];
        }

        if ($request->has('bio')) {
            $user->bio = $data['bio'] ?? null;
        }

        if ($request->has('display_name') && !empty($data['display_name'])) {
            $user->display_name = $data['display_name'];
        }

        $user->save();

        return redirect()->route('settings.index', ['tab' => $activeTab])->with('status', 'Account updated successfully.');
    }
}
