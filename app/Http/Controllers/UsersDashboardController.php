<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UsersDashboardController extends Controller
{

    public function index( Request $request)
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
            return \Carbon\Carbon::parse($date->manual_updated_at)->format('l'); // grouping by days of the week
        });

        $smsCounts = $updatesByDay->map->count();

        return view('dashboard.users.index', compact('totalActivities', 'doneActivities', 'pendingActivities', 'updatesByDay', 'smsCounts'));
    }

    function profile() {
        return view('dashboard.users.profile');
    }
}
