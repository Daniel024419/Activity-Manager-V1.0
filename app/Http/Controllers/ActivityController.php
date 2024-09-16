<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Update;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user(guard: 'users')->id;
        $updates = Update::with('activity')
            ->where('user_id', $userId)
            ->get();


        $activities = Activity::all();

        return view(
            'dashboard.users.activities.index',
            ['activities' => $activities, 'updates' => $updates]
        );
    }


    /**
     * Update the status of the given activity.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateActivityStatus(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'activity_id' => 'required|exists:activities,id',
                'status' => 'required|string',
                'remark' => 'nullable|string',
            ]);

            $updateData = [
                'activity_id' => $request->input('activity_id'),
                'user_id' => $request->user('users')?->id,
                'status' => $request->input('status'),
                'remark' => $request->input('remark'),
                'manual_updated_at' => now(),
            ];

            if (Update::create($updateData)) {
                return redirect()->back()->with('success', 'Update saved successfully!');
            }

            return redirect()->back()->with('error', 'An unexpected error occurred');

        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function store(Request $request)
    {
          try {
            $validatedActivityData = $request->validate([
                'description' => 'required|string|max:255',
            ]);

            $data = [
                'description' => $validatedActivityData['description'] ?? '',
                'created_by' => $request->user('users')?->id,
            ];

            $activity = Activity::create($data);

            if (!$activity) {
                throw new \Exception('Failed to save activity');
            }

            return redirect()->back()->with('success', 'Activity added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function show(string $id)
    {
        $activities = Activity::find($id);

        return view(
            'dashboard.users.activities.show',
            ['activities' => $activities],
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        if ($activity === null) {
            return redirect()->back()->with('error', 'Activity not found');
        }

        try {
            $activity->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An unexpected error occurred');
        }

        return redirect()->back()->with('success', 'Activity deleted successfully');
    }
}
