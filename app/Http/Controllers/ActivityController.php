<?php

namespace App\Http\Controllers;

use App\Models\Update;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $userId = $request->user('users')->id;
        $updates = Update::with('activity')
        ->where('user_id', $userId)
            ->get();

        return view('dashboard.users.activities.index', compact('updates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string',
            'remark' => 'nullable|string',
            'manual_updated_at' => 'required|date',
            'createdBy' => 'required|exists:users,id',
        ]);

        $activity = Activity::find($request->input('activity_id'));

        // Create a new Update instance
        $update = new Update([
            'activity_id' => $request->input('activity_id'),
            'user_id' => $request->user('users')->id,
            'status' => $request->input('status'),
            'remark' => $request->input('remark'),
            'manual_updated_at' => $request->input('manual_updated_at'),
            'createdBy' => $activity->createdBy,
        ]);

        // Save the update to the database
        $update->save();

        // Return a response
        return response()->json([
            'message' => 'Update saved successfully!',
            'update' => $update
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
