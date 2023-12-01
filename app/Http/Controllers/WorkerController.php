<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Resources\WorkerResource;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WorkerResource::collection(Worker::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['name' => 'required|string']);

        $worker = new Worker($validatedData);
        $worker->save();

        return new WorkerResource($worker);
    }

    /**
     * Display the specified resource.
     */
    public function show(Worker $worker)
    {
        return new WorkerResource($worker);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Worker $worker)
    {
        $validatedData = $request->validate(['name' => 'filled|string']);

        $worker->fill($validatedData);
        $worker->save();

        return new WorkerResource($worker);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();

        return response()->json([
            'message' => 'Worker deleted'
        ], 204);
    }
}
