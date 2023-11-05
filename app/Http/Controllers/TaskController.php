<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        return Task::all();
    }

    public function create()
    {
        return response(['message' => 'Not in use'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'due_date' => 'required|date'
        ]);

        return Task::create($request->all());
    }

    public function show(int $id)
    {
        return Task::find($id);
    }

    public function edit(int $id)
    {
        return response(['message' => 'Not in use'], 200);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'due_date' => 'date'
        ]);

        $task = Task::find($id);
        if($task) {
            $task->update($request->all());
        }

        return $task;
    }

    public function destroy(int $id)
    {
        Task::destroy($id);
        return response(['message' => 'Deleted successfully'], 200);
    }
}
