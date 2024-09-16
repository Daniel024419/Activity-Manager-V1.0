<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityUpdatesExport;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        $activities = Activity::paginate(10);
        return view('dashboard.admins.activities.index', 
        ['activities' => $activities]);
    }


    /**
     * Download all activity updates as an Excel file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download( string $id )
    {
        return Excel::download(new ActivityUpdatesExport($id), now() . 'activity_updates.xlsx');
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function filter(Request $request)
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedActivityData = $request->validate([
                'description' => 'required|string|max:255',
            ]);

            $data = [
                'description' => $validatedActivityData['description'] ?? '',
                'created_by' => $request->user()->id,
                
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

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     */
    public function show(string $id)
    {
        $activities = Activity::find($id);

        return view('dashboard.admins.activities.show', 
        ['activities' => $activities], );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $activityId): RedirectResponse
    {
        try {
            $activity = Activity::findOrFail($activityId);
            $activity->delete();

            return redirect()->back()->with('success', 'Activity deleted successfully!');
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->with('error', 'Activity not found');
        }
    }
}
