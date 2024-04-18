<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

use App\Models\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Task;
use Illuminate\Support\Facades\Log; 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $taskRequests = TaskRequest::where('user', auth()->id())->get('task');
        $tasks = Task::where('assignedTo', null)->get();

        $tasksWithAssignment = $tasks->map(function ($task) use ($taskRequests) {
            // Check if the task ID exists in any TaskRequest of the authenticated user
            $isAssigned = $taskRequests->contains('task', $task->id);
        
            // Create a new object with the existing task attributes and isAssigned property
            return [
                'id' => $task->id,
                'name' => $task->name,
                'name_en' => $task->name_en,
                'isAssigned' => $isAssigned,
            ];
        });
        
        Log::info($tasksWithAssignment);
        return view('home', ['objects' => $tasksWithAssignment]);
    }

    public function assign($taskId, $userId)
    {
        $taskRequest = new TaskRequest();
        $taskRequest->timestamps = false;
        $taskRequest->user = $userId; 
        $taskRequest->task = $taskId; 
        $taskRequest->save();
        return redirect()->route('home');
    }
}
