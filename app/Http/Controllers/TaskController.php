<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('assignor_id',Auth::id())->orderBy('id','Desc')->with(['project','assignee'])->get();

        return response()->json([
            'tasks' => $tasks
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tasks()
    {
        $tasks = Task::orderBy('id','Desc')->with(['project','assignee'])->get();
        $projects = Project::orderBy('id','Desc')->get();
        return view('tasks')->with(['tasks'=>$tasks,'projects'=>$projects]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function managetasks()
    {
        $tasks = Task::orderBy('id','Desc')->with(['project','assignee'])->get();
        $projects = Project::orderBy('id','Desc')->get();
        return view('Managetask')->with(['tasks'=>$tasks,'projects'=>$projects]);
    }

        /**
     * Display assignees.
     *
     * @return \Illuminate\Http\Response
     */
    public function assignees()
    {
        $assignees = User::where('id','!=',Auth::id())->orderBy('name','Asc')->get();
        return response()->json([
            'assignees' => $assignees
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mytasks()
    {
        $tasks = Task::where('assignee_id',Auth::id())->with(['project','assignee'])->get();
        return response()->json([
            'tasks' => $tasks
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showmytasks()
    {
        $tasks = Task::where('assignee_id',Auth::id())->with(['project','assignee'])->get();
        return view('mytasks')->with(['tasks'=>$tasks]);
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
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|string|max:225',
        ]);
        $Createtask = Task::create($request->post());
        $task = Task::where('id',$Createtask->id)->with(['project','assignee'])->first();
        $details = [
            'title' => $task->title,
            'description' => $task->description
        ];
        //alert assignee with an email about the new task
        \Mail::to($task->assignee['email'])->send(new \App\Mail\TaskMail($details));
            return response()->json([
                'message' => 'Task Created Successfully!',
                'task' => $task
            ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::with(['project','assignee'])->findOrFail($id);
        return response()->json([
            'task' => $task
        ]);
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showtask($id)
    {
        $task = Task::with(['project','assignee','assignor','comments'])->findOrFail($id);
        $comments = Comment::where('task_id',$id)->with(['user'])->orderBy('created_at','desc')->get();
        // return $task->comments[0]['comment'];
        return view('task')->with(['task'=>$task,'comments'=>$comments]);
    }

   
    public function reassign(Request $request)
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $updateTask = Task::where('id', $request->taskId)
              ->update(['assignee_id' => $request->assignee]);
    
        $updatedTask = Task::where('id',$request->taskId)->with(['assignee'])->first();

        $details = [
            'title' => $updatedTask->title,
            'description' => $updatedTask->description
        ];
        //alert assignee with an email about the new task
        \Mail::to($updatedTask->assignee['email'])->send(new \App\Mail\TaskMail($details));

        return response()->json([
            'message' => 'Task Updated Successfully!',
            'task' => $updatedTask,
            'status'=>'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $request->validate([
            'title' => 'required',
            'description' => 'required|string|max:225',
        ]);
        $updateTask = Task::where('id', $request->taskId)
                            ->update(['title' => $request->title,
                                    'assignee_id' => $request->assignee,
                                    'assignor_id' => $request->uid,
                                    'project_id' => $request->project,
                                    'description' => $request->description
                                ]);
    
        $updatedTask = Task::where('id',$request->taskId)->with(['assignee','project'])->first();

        return response()->json([
            'message' => 'Task Updated Successfully!',
            'task' => $updatedTask,
            'status'=>'success'
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updatestatus(Request $request, Task $task)
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
        $updateTask = Task::where('id', $request->id)
                            ->update(['status' => $request->action,
                                ]);
        if($request->action=="complete"){
            return response()->json([
                'message' => 'Task marked complete!',
                'status'=>'success'
            ]);
        }else{
            return response()->json([
                'message' => 'Task marked in-complete!',
                'status'=>'success'
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $uid = Auth::id();
        $id = $request->taskId;
        $task = Task::find($id);

        if($uid != $task->assignor_id){
            return response()->json([
                'message' => 'You cannot delete this task!',
                'status'=>'fail'
            ]);
        }else{
            Task::where('id', $id)->delete();
            return response()->json([
                'message' => 'Task Deleted Successfully!',
                'id' => $id,
                'status'=>'success'
            ]);
        }
        
        
    }
}
