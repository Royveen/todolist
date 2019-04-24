<?php

namespace App\Http\Controllers;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'date' => 'required'
        ]);

        $task = new Task;

        $task->description = $request->input('description');
        $task->date = $request->input('date');
        $task->status = $request->input('status');
        $task->date_completed = $request->input('date_completed');
        $task->user = auth()->user()->id;
        $task->save();
        
        return response($task,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $user_id = auth()->user('id')->id;

        if($id == 'completed') {
            $tasks = Task::orderBy('updated_at', 'desc')->where('status', $id)->where('user',$user_id)->get();
        }else {
            $tasks = Task::orderBy('date', 'asc')
            ->where('date','like', $id.'%')
            ->where('status', 'pending')
            ->where('user',$user_id)
            ->get();
        }
        return response($tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required',
            'date' => 'required'
        ]);

        $task = Task::find($id);

        $task->description = $request->input('description');
        $task->date = $request->input('date');
        $task->date_completed = $request->input('date_completed');
        $task->status = $request->input('status');
        $task->save();
        return response($task,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response('success',201);
    }
}
