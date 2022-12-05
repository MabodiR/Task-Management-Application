@extends('layouts.app')

@section('content')

<!-- Tasks List -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
  <div class="col-sm-12 col-xl-8">
    <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Task Details</h6>
        <dl class="row mb-0">
            <dt class="col-sm-4">Task Title</dt>
            <dd class="col-sm-8">{{$task->title}}.</dd>

            <dt class="col-sm-4">Task Description</dt>
            <dd class="col-sm-8">{{$task->description}}.</dd>

            <dt class="col-sm-4">Assigned To</dt>
            <dd class="col-sm-8 assignedTo">{{$task->assignee['name']}}.</dd>

            <dt class="col-sm-4 text-truncate">Created By</dt>
            <dd class="col-sm-8">{{$task->assignor['name']}}.</dd>

           <dt class="col-sm-4 text-truncate">Created at</dt>
            <dd class="col-sm-8">{{date('l jS \\of F Y h:i:s A', strtotime($task->created_at)) }}.</dd>

        </dl>
    </div>
</div>


<div class="col-sm-12 col-md-6 col-xl-4">
    <div class="h-100 bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Assignee</h6>
        </div>
         <!-- success message -->
         <div class="alert" id="successMessages" role="alert">
            <span id="messages"></span>
        </div>
        <div class="d-flexs mb-0">
          <form method="POST" >
              <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
              <input  type="number" name="taskId" value="{{$task->id}}" hidden>
            <select class="form-select mb-3 assignees" name="assignee" id="assignees" aria-label="Default select example">
                    <option value="{{$task->assignee['id']}}">{{$task->assignee['name']}}</option>
                 </select>
                 <button type="submit" id="reAssignTask" class="btn btn-primary">Re-assign</button>
          </form>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <h6 class="mb-0">Task Status</h6>
        </div>
           <!-- success message -->
         <div class="alert" id="successMessageU" role="alert">
            <span id="message"></span>
        </div>

          <form method="POST" >
            <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
                <select class="form-select status" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option value="{{$task->id}}" selected>@if ($task->status !="complete") In-progress @else completed @endif</option>
                    <option value="{{$task->id}}">complete</option>
                    <option value="{{$task->id}}">In-Progress</option>
                </select>
            </form>
        </div>
    </div>
</div>



<div class="col-sm-12 col-md-6 col-xl-8">
    <div class="h-100 bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Comments</h6>
           
        </div>
          <!-- success message -->
          <div class="alert" id="successMessage" role="alert">
            <span id="message"></span>
        </div>
        <div class="m-n2 mb-4">
          <form method="POST" >
             <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
              <input  type="number" name="uid" value="@if(Auth::check()){{Auth::user()->id}}@endif" hidden>
              <input  type="number" name="taskId" value="{{$task->id}}" hidden>
              <input class="form-control bg-transparent" name="comment" type="text" placeholder="Comment here">
              <button type="button" class="btn btn-primary btn-sm mt-3 ms-2" id="createComment">Comment</button>
          </form>
        </div>
        <span class="displayComment">
        @foreach ($comments as $comment)
        <div class="d-flex align-items-center border-bottom py-3 mt-4">
            <img class="rounded-circle flex-shrink-0" src="../img/user.png" alt="" style="width: 40px; height: 40px;">
            <div class="w-100 ms-3">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-0">{{$comment->user['name']}}</h6>
                    <small><time>{{ $comment->created_at->diffForHumans() }}</time></small>
                </div>
                <span>{{$comment->comment}}</span>
            </div>
        </div>
        @endforeach
     </span>
    </div>
</div>

 <!-- start task modal -->
 <div class="modal fade" id="task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-secondary rounded h-100 p-4">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                <button type="button" style="color:red;" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="">
            <form method="POST" >
                <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
                <input  type="number" name="uid" value="@if(Auth::check()){{Auth::user()->id}}@endif" hidden>
                <!-- Preventing spam submitted through forms -->
                <x-honeypot /> 	
                <!--  -->
                    <!-- success message -->
                <div class="alert" id="successMessage" role="alert">
                    <span id="message"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="title" id="title" required>
                    <label for="floatingInput">Task Name</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select mb-3 projects" name="project" id="projects" aria-label="Default select example">
                    </select>
                    <label for="floatingInput">Project</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select mb-3 assignees" name="assignee" id="assignees" aria-label="Default select example">
                    <option value="@if(Auth::check()){{Auth::user()->id}}@endif">Self</option>
                    </select>
                    <label for="floatingInput">Assign Task</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" id="description" placeholder="More details about the Task.."
                            style="height: 100px;" required></textarea>
                    <label for="floatingTextarea">Task Description</label>
                </div>
                <button type="submit" id="createTask" class="btn btn-primary">Create Task</button>
            </form>
        </div>
      </div>
    </div>
   </div>
    <!-- end task modal -->

    <!-- start project modal -->
    <div class="modal fade" id="project" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-secondary rounded h-100 p-4">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>
                <button type="button" style="color:red;" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="">
            <form method="POST" >
              <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
                 <!-- success message -->
                <div class="alert" id="successMessageP" role="alert">
                    <span id="message"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" required>
                    <label for="floatingInput">Project Name</label>
                </div>
               <!-- Preventing spam submitted through forms -->
				<x-honeypot /> 	
				<!--  -->
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" placeholder="More details about the project.."
                         style="height: 150px;" required></textarea>
                    <label for="floatingTextarea">Project Description</label>
                </div>
                <button type="submit" id="createProject" class="btn btn-primary">Create Project</button>
           </form>
        </div>
      </div>
    </div>
   </div>
    <!-- end project modal -->
   </div>
</div>
@endsection
