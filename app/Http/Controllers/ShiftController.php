<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Resources\ShiftResource;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ShiftResource::collection(Shift::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'worker_id' => 'required|exists:workers,id',
            'start_time' => 'required|date_format:Y-m-d H:i:s'
        ]);

        $startTime = Carbon::parse($validatedData['start_time']);
        $endTime = Carbon::parse($validatedData['start_time'])->addHours(8);

        $acceptedStartTimes = ["00:00:00", "08:00:00", "16:00:00"];

        //check if selected start time is valid
        if (!in_array($startTime->format('H:i:s'), $acceptedStartTimes)) {
            return response()->json([
                'error' => 'The selected start time is invalid'
            ], 400);
        }

        // Check if the worker already has a shift on this day
        $existingShifts = Shift::where('worker_id', $validatedData['worker_id'])
            ->whereDate('start_time', $startTime->format('Y-m-d'))
            ->get();

        if ($existingShifts->count() > 0) {
            return response()->json([
                'error' => 'Worker already has a shift on this day'
            ], 400);
        }

        // Create the shift
        $shift = new Shift($validatedData);
        $shift['end_time'] = $endTime;
        $shift->save();

        return new ShiftResource($shift);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        return new ShiftResource($shift);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        $validatedData = $request->validate([
            'worker_id' => 'filled|exists:workers,id',
            'start_time' => 'filled|date_format:Y-m-d H:i:s'
        ]);


        //Updating start time automatically updates end time
        $startTime = $request->start_time ?
            Carbon::parse($validatedData['start_time']) :
            Carbon::parse($shift->start_time);
        $endTime = $request->start_time ?
            Carbon::parse($validatedData['start_time'])->addHours(8) :
            Carbon::parse($shift->end_time);

        // Check if the worker already has a shift on this day
        $existingShifts = Shift::where('worker_id', $validatedData['worker_id'])
            ->whereDate('start_time', $startTime->format('Y-m-d'))
            ->where('id', '!=', $shift->id)
            ->get();

        if ($existingShifts->count() > 0) {
            return response()->json(['error' => 'Worker already has a shift on this day'], 400);
        }

        // Update the shift
        $shift->fill($validatedData);
        $shift['end_time'] = $endTime;

        $shift->save();

        return new ShiftResource($shift);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
