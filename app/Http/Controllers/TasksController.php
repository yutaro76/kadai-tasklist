<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            
            $user = \Auth::user();
            
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(5);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
         return view('tasks.index', $data);
         
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::check()) {
        
        $task = new Task;
        
        return view('tasks.create', ['task' => $task,]);
        } else {
        return view('tasks.index');
    }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
            ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
            ]);
            
        
        return redirect('/');
        
        // $task = new Task;
        // // $task->status = $request->status;
        // // $task->content = $request->content;
        
    //     $task->save();
        
    //     if (\Auth::check()) {
        
    //     return redirect('/');
        
    //     }else {
    //     return view('tasks.index');
    // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $task = Task::findOrFail($id);
        
        // $user->loadRelationshipCounts();
        
        $user = $task->user_id;
        
        // $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(5);
        
        if (\Auth::id() === $user) {
        
        return view('tasks.show', [
            'user' => $user,
            'task' => $task,
            ]);
            
        } else {
            return redirect('/');
        }
          
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
        
        return view('tasks.edit', ['task' => $task,]);
        
        } else {
            return redirect('/');
        }

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
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
            ]);
        
        $task = Task::FindOrFail($id);
        $task->status = $request->status;
        $task->content = $request->content;
        
        $task->save();

        return redirect('/');
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::FindOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
        
        $task->delete();
        }
        
        return redirect('/');
        
    }
}
