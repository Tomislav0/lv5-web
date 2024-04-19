<?php

namespace App\Http\Controllers;

use App\Models\TaskRequest;
use App\Models\User;
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
        $user = User::where('id', auth()->id())->get();
        if ($user[0]->role === config('roles.student')) {

            $taskRequests = TaskRequest::where('user', auth()->id())->get('task');
            $tasks = Task::where('assignedTo', null)->get();

            $tasksWithAssignment = $tasks->map(function ($task) use ($taskRequests) {
                $isAssigned = $taskRequests->contains('task', $task->id);
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'name_en' => $task->name_en,
                    'isAssigned' => $isAssigned,
                ];
            });

            return view('home', ['objects' => $tasksWithAssignment]);
        } else if ($user[0]->role === config('roles.teacher')) {
            $tasks = Task::where('createdBy', auth()->id())->get(); //svi profesorovi taskovi
            $taskRequests = TaskRequest::whereIn('task', $tasks->pluck('id')->toArray())->get(); // svi zahtjevi za profesorove zadatke

            $tasksWithAssignment = $tasks->map(function ($task) use ($taskRequests) {
                $assignedUsers = $taskRequests->where('task', $task->id)->pluck('user');
                $assignedUsers = $assignedUsers->map(function ($user) {
                    $userData = User::where('id', $user)->first();
                    return [
                        "id" => $userData->id,
                        "name" => $userData->name
                    ];
                });

                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'name_en' => $task->name_en,
                    'users' => $assignedUsers,
                    'isAssigned' => $task->assignedTo,
                ];
            });
            return view('home', ['objects' => $tasksWithAssignment]);
        } else {
            $tasks = Task::all();
            return view('home', ['objects' => $tasks]);
        }
    }

    public function applyToTask($taskId, $userId)
    {
        $taskRequest = new TaskRequest();
        $taskRequest->timestamps = false;
        $taskRequest->user = $userId;
        $taskRequest->task = $taskId;
        $taskRequest->save();
        return redirect()->route('home');
    }
}
