<?php

namespace App\Actions\Auth;

use App\Models\Task\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class User
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     */

    public function taskList($status = false)
    {
        try {
            $task = Task::select('id', 'title', 'description', 'status')->paginate(15);
            return $task;
        } catch (\Throwable $th) {
            Log::error('Fetch Task List Error: ' . $th->getMessage());
            return false;
        }
    }

    public function createTask($data)
    {
        try {
            $task = Task::create($data);
            return $task;
        } catch (\Throwable $th) {
            Log::error('Create Task Error: ' . $th->getMessage());
            return false;
        }
    }

    public function findTaskById($task)
    {
        try {
            if(!$task){
                return "invalid";
            }
            return $task;
        } catch (\Throwable $th) {
            Log::error('Find Task Error: ' . $th->getMessage());
            return false;
        }
    }

    public function updateTask($task, $data){
        try {
            $task=$task->update($data);
            return $task;
        } catch (\Throwable $th) {
            Log::error('updating Task Error: ' . $th->getMessage());
            return false;
        }

    }

    public function deleteTask($task){
        try {
            $task->delete();
            return true;
        } catch (\Throwable $th) {
            Log::error("Deleting Task Error: ", $th->getMessage());
            return false;
        }

    }
}
