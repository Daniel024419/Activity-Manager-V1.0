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

    /**
     * Display a listing of all users (both regular users and admins).
     *
     */
    public function users()
    {
        $allUsers = [...User::all(), ...Admin::all()];
        return view(
            'dashboard.admins.users.index',
            [
                'users' => $allUsers,
                'roles' => Roles::all()
            ]
        );
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
