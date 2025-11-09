<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Task\StoreRequest;
use App\Http\Requests\Auth\Task\UpdateRequest;
use App\Http\Resources\Auth\TaskResource;
use App\Models\Task\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, Request $request)
    {
        $task = $user->taskList();
        if ($task === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch task list.'
            ], 500);
        }
        return response()->json(
            [
                'status' => 'success',
                'message' =>  TaskResource::collection($task),
                'meta' => [
                    'current_page' => $task->currentPage(),
                    'last_page' => $task->lastPage(),
                    'per_page' => $task->perPage(),
                    'total' => $task->total(),
                ],
                'links' => [
                    'first' => $task->url(1),
                    'last'  => $task->url($task->lastPage()),
                    'prev'  => $task->previousPageUrl(),
                    'next'  => $task->nextPageUrl(),
                ],
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, User $user, Task $task)
    {
        Gate::authorize('create', $task);
        $validated = $request->validated();
        $data = $user->createTask($validated);
        if ($data === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create task.'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => new TaskResource($data)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, User $user)
    {
        Gate::authorize('view', $task);
        $data = $user->findTaskById($task);
        if ($data === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch task.'
            ], 500);
        }else if($data=="invalid"){
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => new TaskResource($data)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $updateRequest, Task $task, User $user)
    {
        Gate::authorize('update', $task);
        $validated=$updateRequest->validated();
        $data=$user->updateTask($task, $validated);
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task.'
            ], 500);
        }
        return response()->json( ['status'=>'success', 'message'=>new TaskResource($data)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, User $user)
    {
        Gate::authorize('delete', $task);
        $data=$user->deleteTask($task);
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete task.'
            ], 500);
        }
        return response()->json([
            'status'=>'success',
            'message'=>"Task Deleted",
        ], 204);
    }
}
