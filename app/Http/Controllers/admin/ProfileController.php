<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function index()
    {
        return view('admin.profile.index');
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        return view('admin.profile.edit');
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Add password validation only if password fields are filled
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $rules['current_password'] = 'required|string';
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Update basic information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->position = $validated['position'] ?? null;
        $user->department = $validated['department'] ?? null;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Upload new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        // Handle password change
        if ($request->filled('current_password') && $request->filled('new_password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the change password form.
     */
    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Password changed successfully!');
    }
}
