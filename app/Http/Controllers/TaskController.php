<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        //Return all task from the database
        return Task::all();
    }

    public function create()
    {
        //We not use it since it's only api
        return response(['message' => 'Not in use'], 200);
    }

    public function store(Request $request)
    {
        //Validate inputs
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'due_date' => 'required|date'
        ]);

        //Return the created task
        return Task::create($request->all());
    }

    public function show(int $id)
    {
        //Return the task with the requested id
        return Task::find($id);
    }

    public function edit(int $id)
    {
        //We not use it since it's only api
        return response(['message' => 'Not in use'], 200);
    }

    public function update(Request $request, int $id)
    {
        //Validate inputs
        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'due_date' => 'date'
        ]);

        //Find task
        $task = Task::find($id);

        //If task exist update
        if ($task) {
            $task->update($request->all());
        }

        //Return task
        return $task;
    }

    public function destroy(int $id)
    {
        //Destroy task
        $ret = Task::destroy($id);

        //Give response based on we deleted or not
        if($ret){
            return response(['message' => 'Deleted successfully'], 200);
        }else{
            return response(['message' => 'Task not find'], 422);
        }
    }
}
