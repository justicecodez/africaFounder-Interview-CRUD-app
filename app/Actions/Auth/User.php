<?php

namespace App\Actions\Auth;

use App\Models\Task\Task;

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

    public function taskList(){
        $task=Task::select('id','title','description','status')->paginate(15);
        return $task;
    }
}
