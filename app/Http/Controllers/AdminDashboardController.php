<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Roles;
use App\Models\Activity;
use App\Exports\AdminExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Enums\Roles as RoleEnum;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all activities with updates and associated users
        $activities = Activity::paginate(5);

        // Prepare data for SMS Count Chart
        $smsCounts = $this->getActivityCounts( Activity::latest()->get() );

        // Prepare data for Activity Status Chart
        $activityStatus = $this->getActivityStatus($activities);

        // Prepare data for Reports Chart
        $reports = $this->getReports(Activity::all() );

        return view('dashboard.admins.index', compact('activities', 'smsCounts', 'activityStatus', 'reports'));
    }

    /**
     * Get SMS Counts for the chart.
     *
     * @return array
     */
    private function getActivityCounts( $activities )
    {
        // Initialize an array to hold counts for each day of the week
        $groupedActivities = $activities->groupBy(fn ($activity) => Carbon::parse($activity->created_at)->format('l'));
        $smsCounts = $groupedActivities->map(fn ($activities) => $activities->sum(fn ($activity) => $activity->updates->count()));

        $smsCountsData = $smsCounts->map(fn ($count, $day) => [
            'label' => $day,
            'value' => $count,
        ])->toArray();

        return [
            'labels' => array_column($smsCountsData, 'label'),
            'series' => [array_column($smsCountsData, 'value')],
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
        $statusCounts = ['done' => 0, 'pending' => 0];

        foreach ($activities as $activity) {
            foreach ($activity->updates as $update) {
                if (array_key_exists($update->status, $statusCounts)) {
                    $statusCounts[$update->status]++;
                }
            }
        }

        return [
            'labels' => ['Done', 'Pending'],
            'series' => [array_values($statusCounts)]
        ];
    }

    /**
     * Get Reports data for the chart.
     *
     * @return array
     */
    private function getReports($activities)
    {

        // dd($activities);
        // Initialize an array to hold the counts for each day
        $dailyCounts = [];

        // Iterate over the activities
        foreach ($activities as $activity) {
            // Get the date of the activity
            $date = Carbon::parse($activity->created_at)->format('Y-m-d'); // Format date as 'YYYY-MM-DD'

            // If the date is not already in the array, initialize it
            if (!isset($dailyCounts[$date])) {
                $dailyCounts[$date] = 0;
            }

            // Increment the count for the date
            $dailyCounts[$date]++;
        }

        // Sort the dates to ensure chronological order
        ksort($dailyCounts);

        // Prepare the data for the report
        $labels = array_keys($dailyCounts);
        $series = [array_values($dailyCounts)];

        return [
            'labels' => $labels,
            'series' => $series
        ];
    }


    /**
     * Display a listing of all users (both regular users and admins).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function users()
    {
        $users = User::all();
        $admins = Admin::all();

        $allUsers = $users->merge($admins);

        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;

        $paginatedItems = new LengthAwarePaginator(
            $allUsers->slice(($currentPage - 1) * $perPage, $perPage)->all(),
            $allUsers->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('dashboard.admins.users.index', [
            'users' => $paginatedItems,
            'roles' => Roles::all()
        ]);
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, now() . 'users.xlsx');
    }

    /**
     * Export all admins to an Excel file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportAdmins()
    {
        return Excel::download(new AdminExport, now() . 'admins.xlsx');
    }

    public function createUser(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string|max:255',
            ]);

            $role = RoleEnum::getRoleIdByValue($validated['role']);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role_id' => $role,
                'created_by' => $request->user()->id,
            ];

            if ($validated['role'] == RoleEnum::ADMIN->value) {
                Admin::create($data);
                return redirect()->back()->with('success', 'Admin created successfully');
            }

            User::create($data);

            return redirect()->back()->with('success', 'User created successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete the specified user.
     *
     * @param int $userId
     * @return RedirectResponse
     */
    public function deleteUser(int $userId): RedirectResponse
    {
        try {
            $user = User::findOrFail($userId) ?? Admin::findOrFail($userId);

            $user->delete();

            return redirect()->back()->with('success', 'User deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found');
        }
    }
}
