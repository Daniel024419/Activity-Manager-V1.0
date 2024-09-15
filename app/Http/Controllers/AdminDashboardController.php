<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all activities with updates and associated users
        $activities = Activity::with('updates.user')->get();

        // Prepare data for SMS Count Chart
        $smsCounts = $this->getSmsCounts();

        // Prepare data for Activity Status Chart
        $activityStatus = $this->getActivityStatus($activities);

        // Prepare data for Reports Chart
        $reports = $this->getReports();

        return view('dashboard.admins.index', compact('activities', 'smsCounts', 'activityStatus', 'reports'));
    }

    /**
     * Get SMS Counts for the chart.
     *
     * @return array
     */
    private function getSmsCounts()
    {
        // Sample implementation; replace with actual data retrieval
        // Fetching SMS count data based on your application's logic
        return [
            'labels' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'series' => [[12, 9, 7, 8, 5]] // Replace with real data
        ];
    }

    /**
     * Get Activity Status for the chart.
     *
     * @param $activities
     * @return array
     */
    private function getActivityStatus($activities)
    {
        // Initialize counters
        $statuses = ['done' => 0, 'pending' => 0];

        // Count activities based on status
        foreach ($activities as $activity) {
            foreach ($activity->updates as $update) {
                if (isset($statuses[$update->status])) {
                    $statuses[$update->status]++;
                }
            }
        }

        return [
            'labels' => ['Done', 'Pending'],
            'series' => [[
                $statuses['done'],
                $statuses['pending']
            ]]
        ];
    }

    /**
     * Get Reports data for the chart.
     *
     * @return array
     */
    private function getReports()
    {
        // Sample implementation; replace with actual data retrieval
        // Fetching reports data based on your application's logic
        return [
            'labels' => ['January', 'February', 'March', 'April', 'May'],
            'series' => [[4, 6, 3, 9, 7]] // Replace with real data
        ];
    }

    public function users()
    {
        $allUsers = [...\App\Models\User::all(), ...\App\Models\Admin::all()];
        return view('dashboard.admins.users.index', ['users' => $allUsers]);
    }
}
