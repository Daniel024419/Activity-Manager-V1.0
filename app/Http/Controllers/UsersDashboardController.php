<?php

namespace App\Http\Controllers;

use App\Models\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersDashboardController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->user('users')->id;

        // Fetch activities where the logged-in user created updates
        $updates = Update::with('activity')
            ->where('user_id', $userId)
            ->get();

        // Count the total activities
        $totalActivities = $updates->count();

        // Count based on status
        $doneActivities = $updates->where('status', 'done')->count();
        $pendingActivities = $updates->where('status', 'pending')->count();

        // Group updates by day
        $updatesByDay = $updates->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('l'); // grouping by days of the week
        });

        $smsCounts = $updatesByDay->map->count();

        return view('dashboard.users.index', compact('totalActivities', 'doneActivities', 'pendingActivities', 'updatesByDay', 'smsCounts'));
    }

    function profile()
    {
        return view('dashboard.users.profile');
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
            $admin = User::findOrFail($request->input('user_id'));

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
