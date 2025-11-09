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
                'data' => 'Failed to fetch task list.'
            ], 500);
        }
        return response()->json(
            [
                'status' => 'success',
                'data' =>  TaskResource::collection($task),
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
                'data' => 'Failed to create task.'
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
    public function show(Task $task, User $user)
    {
        Gate::authorize('view', $task);
        $data = $user->findTaskById($task);
        if ($data === false) {
            return response()->json([
                'status' => 'error',
                'data' => 'Failed to fetch task.'
            ], 500);
        }else if($data=="invalid"){
            return response()->json([
                'status' => 'error',
                'data' => 'Task not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new TaskResource($data)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Task $task, UpdateRequest $updateRequest,  User $user)
    {
        Gate::authorize('update', $task);
        $validated=$updateRequest->validated();
        $data=$user->updateTask($task, $validated);
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'data' => 'Failed to update task.'
            ], 500);
        }
        return response()->json( ['status'=>'success', 'data'=>new TaskResource($data)]);
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
                'data' => 'Failed to delete task.'
            ], 500);
        }
        return response()->json([
            'status'=>'success',
            'data'=>"Task Deleted",
        ], 204);
    }

    public function statusToggler(Request $request, User $user){
        $status=$request->status;
        $data=$user->statusToggler($status);
        if ($data === false) {
            return response()->json([
                'status' => 'error',
                'data' => 'Failed to fetch task list by Status.'
            ], 500);
        }
        return response()->json(
            [
                'status' => 'success',
                'data' =>  TaskResource::collection($data),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ],
                'links' => [
                    'first' => $data->url(1),
                    'last'  => $data->url($data->lastPage()),
                    'prev'  => $data->previousPageUrl(),
                    'next'  => $data->nextPageUrl(),
                ],
            ],
            200
        );

    }
}
