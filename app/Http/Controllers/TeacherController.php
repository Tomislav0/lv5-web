<?php

namespace App\Http\Controllers;

use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\User;
class TeacherController extends Controller
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
    public function newTask($lang)
    {
        $user = User::where('id', auth()->id())->get(); 
        if($user[0]->role == config('roles.student')) return redirect()->route('home');
        App::setLocale($lang);
        return view('task');
    }

    public function storeForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'task_aim' => 'required',
            'study_type' => 'required|in:stručni,preddiplomski,diplomski', 
        ]);

        $validatedData['createdBy'] = auth()->id();

        Task::create($validatedData);

        session()->flash('success', 'Item was successfully added!');

        return redirect()->route('home')->with('success', 'Form submitted successfully!');
    }
}
