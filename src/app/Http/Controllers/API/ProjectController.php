<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // all projects
    public function index()
    {
        $projects = Project::with(['user', 'status'])->get();
        
        return $projects;
    }
    
    // add project
    public function add(StoreProjectRequest $request)
    {
        $project = new Project([
            'user_id' => Auth::user()->id,
            'status_id' => $request->status_id,
            'title' => $request->title,
            'deadline' => $request->deadline,
            'description' => $request->description,
        ]);
        $project->save();
        
        return response()->json('The project successfully added');
    }
    
    // edit project
    public function edit($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }
    
    // update project
    public function update($id, UpdateProjectRequest $request)
    {
        $project = Project::find($id);
        $project->update($request->all());
        
        return response()->json('The project successfully updated');
    }
    
    // delete project
    public function delete($id)
    {
        $project = Project::find($id);
        $project->delete();
        
        return response()->json('The project successfully deleted');
    }
}
