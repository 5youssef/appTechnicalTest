<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
     // all statuses
     public function index()
     {
         $statuses = Status::all()->toArray();
         return array_reverse($statuses);
     }
 
     // add status
     public function add(Request $request)
     {
         $status = new Status([
             'name' => $request->name,
         ]);
         $status->save();
 
         return response()->json('The status successfully added');
     }
 
     // edit status
     public function edit($id)
     {
         $status = Status::find($id);
         return response()->json($status);
     }
 
     // update status
     public function update($id, Request $request)
     {
         $status = Status::find($id);
         $status->update($request->all());
 
         return response()->json('The status successfully updated');
     }
 
     // delete status
     public function delete($id)
     {
         $status = Status::find($id);
         $status->delete();
 
         return response()->json('The status successfully deleted');
     }
}
