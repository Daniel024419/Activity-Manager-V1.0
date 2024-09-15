<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityUpdatesExport;

class AdminActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $activities = Activity::with('updates.user')->get();
        return view('dashboard.admins.activities.index', compact('activities'));
    }


    public function download()
    {
        return Excel::download(new ActivityUpdatesExport, 'activity_updates.xlsx');
    }

    public function report(Request $request)
    {

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $activities = Activity::whereHas('updates', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('manual_updated_at', [$startDate, $endDate]);
        })->with('updates.user')->get();

        return view('dashboard.admins.activities.report', compact('activities', 'startDate', 'endDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        // Create a new activity
        $activity = new Activity();
        $activity->description = $validatedData['description'];
        $activity->save();

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Activity added successfully!');
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
