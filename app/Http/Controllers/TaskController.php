<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();

        Task::create([
            'title'          => $data['title'],
            'description'    => $data['description'],
            'owner_id'       => auth()->user()->id,
        ]);

        return response()->json(['msg' => 'Task Created Successfully']);
        
    }

    public function update(Request $request, $task_id) {

        $validator = Validator::make($request->all(), [
            'email' => 'nullable|exists:users,email',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();
        
        if(isset($data['email'])){
            $user = User::where('email', $data['email'])->first();
        }

        

        $task = Task::find($task_id);

        $task->start_date = isset($data['start_date']) ? date('Y-m-d', strtotime($data['start_date'])) : $task->start_date;
        $task->end_date = isset($data['end_date']) ? date('Y-m-d', strtotime($data['end_date'])) : $task->end_date;
        $task->user_id = isset($data['email']) ? $user->id : $task->user_id;
        $task->status = isset($data['status']) ? $data['status'] : $task->status;

        $task->save();

        return response()->json(['msg' => 'Task Updated Successfully']);
    }

    public function delete(Request $request) {

        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();

        $task = Task::find($data['task_id']);

        $task->delete();

        return response()->json(['msg' => 'Task Deleted Successfully']);
        
    }

    public function get($id) {

        $task = Task::with('user')->find($id);        

        return response()->json(['task' => $task]);
        
    }



    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string',
            'value' => 'nullable',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();

        $tasks = Task::query();

        if(isset($data['filter'])){

            if ($data['filter'] == 'status') {

                $currentDate = Carbon::now();

                if($data['value'] == 'active'){
                    $tasks->where('start_date', '<=', $currentDate)
                    ->where('end_date', '>=', $currentDate);
                } elseif($data['value'] == 'overdue') {
                    $tasks->where('end_date', '<', $currentDate)->where('status', '!=', 'completed');
                } elseif($data['value'] == 'expired') {
                    $tasks->where('start_date', '>', $currentDate)->where('status', 'completed');
                } elseif($data['value'] == 'completed') {
                    $tasks->where('status', 'completed');
                } elseif($data['value'] == 'pending') {
                    $tasks->where('status', 'pending');
                } elseif($data['value'] == 'inprogress') {
                    $tasks->where('status', 'inprogress');
                }
            }
        }

    
        $tasks = $tasks->where('owner_id', auth()->user()->id)->latest()->get();

        return response()->json(['tasks' => $tasks]);
    }

    public function count(){

        //count owned task
        $owned_task = Task::where('owner_id', auth()->user()->id)->count();

        //count assigned task
        $assigned_task = Task::where('user_id', auth()->user()->id)->count();

        //count ongoing task
        $inprogress = Task::where('status', 'inprogress')->count();

        //count completed task
        $completed = Task::where('status', 'completed')->count();

        return response()->json([
            'owned_task' => $owned_task,
            'assigned_task' => $assigned_task,
            'inprogress' => $inprogress,
            'completed' => $completed,
        ]);

    }

    public function getLatest(){

        $user = auth()->user();

        $owned_tasks = Task::where('owner_id', $user->id)->latest()->get();
        $assigned_tasks = Task::where('user_id', $user->id)->latest()->get();
        $tasks = $owned_tasks->merge($assigned_tasks)->sortByDesc('created_at')->take(5);


        return response()->json(['tasks' => $tasks]);

    }

    public function assignedList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string',
            'value' => 'nullable',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors(), 422);
        }

        $data = $request->all();

        $tasks = Task::query();

        if(isset($data['filter'])){

            if ($data['filter'] == 'status') {

                $currentDate = Carbon::now();

                if($data['value'] == 'active'){
                    $tasks->where('start_date', '<=', $currentDate)
                    ->where('end_date', '>=', $currentDate);
                } elseif($data['value'] == 'overdue') {
                    $tasks->where('end_date', '<', $currentDate)->where('status', '!=', 'completed');
                } elseif($data['value'] == 'expired') {
                    $tasks->where('start_date', '>', $currentDate)->where('status', 'completed');
                } elseif($data['value'] == 'completed') {
                    $tasks->where('status', 'completed');
                } elseif($data['value'] == 'pending') {
                    $tasks->where('status', 'pending');
                } elseif($data['value'] == 'inprogress') {
                    $tasks->where('status', 'inprogress');
                }
            }
        }

    
        $tasks = $tasks->where('user_id', auth()->user()->id)->latest()->get();

        return response()->json(['tasks' => $tasks]);
    }





}
