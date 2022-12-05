<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
    public function index()
    {

        $tasks = Task::where('assignee_id',Auth::id())
                        ->where('status','!=','complete')
                        ->orderBy('created_at','desc')
                        ->with(['project','assignee','comments'])->get();
       
        return view('home')->with(['tasks'=>$tasks]);
       
    }
}
