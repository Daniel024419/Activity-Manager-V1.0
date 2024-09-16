<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminProfileController extends Controller
{
    /**
     * view profile.
     */
    public function index()
    {
        return view('dashboard.admins.profile');
    }

    /**
     * Edit an existing user's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role_id' => 'required|integer|exists:roles,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $userId = $request->input('user_id');
        $user = User::where('id', $userId)->first() ?? Admin::where('id', $userId)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'The user could not be found.');
        }

        try {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role_id' => $request->input('role_id'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred when updating the user.');
        }

        return redirect()->back()->with('success', 'Profile edited successfully');
    }

    
    /**
     * Update the authenticated user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        try {
            $admin = Admin::findOrFail($request->input('user_id'));

            $admin->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

            if ($request->filled('password')) {
                $admin->update(['password' => bcrypt($request->input('password'))]);
            }

            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (ModelNotFoundException | ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
