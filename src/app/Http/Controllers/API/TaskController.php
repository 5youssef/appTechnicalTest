<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    
    public function index()
    {
        $tasks = Task::with(['user', 'status', 'project'])->get();
        
        return $tasks;
    }

    public function tasks_title()
    {
        $tasks = Task::get('title')->toArray();
        
        return array_reverse($tasks);
    }
    
    // add task
    public function add(Request $request)
    {
        $task = new Task([
            'user_id' => $request->user_id,
            'status_id' => $request->status_id,
            'project_id' => $request->project_id,
            'title' => $request->title,
            'deadline' => $request->deadline,
            'description' => $request->description,
        ]);
        $task->save();
        
        return response()->json('The task successfully added');
    }
    
    // edit task
    public function edit($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }
    
    // update task
    public function update($id, Request $request)
    {
        $task = Task::find($id);
        $task->update($request->all());
        
        return response()->json('The task successfully updated');
    }
    
    // delete task
    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();
        
        return response()->json('The task successfully deleted');
    }

    public function updateTasksStatus(Request $request, $id)
    {

        $task = Task::find($id);
        $task->status_id = $request->status_id;
        $task->save();
        
        return response('Updated Successfully.', 200);

    }

}
