<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Task\StoreRequest;
use App\Http\Resources\Auth\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, Request $request)
    {
        $status=$request->status;
        $task=$user->taskList($status);
        if ($task === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch task list.'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'data' => TaskResource::collection($task)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, User $user)
    {
        $validated = $request->validated();
        $data=$user->createTask($validated);
        if ($data === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create task.'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'data' => new TaskResource($data)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        $id=$request->id;
        $data=$user->findTaskById($id);
        if ($data === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch task.'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'data' => new TaskResource($data)
        ], 200);
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
