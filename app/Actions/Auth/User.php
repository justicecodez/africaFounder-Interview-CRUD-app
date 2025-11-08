<?php

namespace App\Actions\Auth;

use App\Models\Task\Task;
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

    public function taskList($status=false){
        try {
            if ($status) {
                $task=Task::select('id','title','description','status')->where('status',$status)->paginate(15);
            }else{
                $task=Task::select('id','title','description','status')->paginate(15);
            }
            return $task;
        } catch (\Throwable $th) {
            Log::error('Fetch Task List Error: ' . $th->getMessage());
            return false;
        }

    }

    public function createTask($data){
        try {
            $task=Task::create($data);
            return $task;
        } catch (\Throwable $th) {
            Log::error('Create Task Error: ' . $th->getMessage());
            return false;
        }
    }

    public function findTaskById($id){
        try {
            $task=Task::find($id);
            return $task;
        } catch (\Throwable $th) {
            Log::error('Find Task Error: ' . $th->getMessage());
            return false;
        }
    }


}
