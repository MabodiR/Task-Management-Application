@extends('layouts.app')

@section('content')


<!-- Tasks List -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">

      <!-- Add new Task -->
      <div class="col-sm-12 col-xl-12">
        <div class="bg-secondary rounded h-100 p-4">
           
            <form method="POST" >
              <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
              <input  type="number" id="hidenTaskId" name="taskId" hidden>
              <input  type="number" name="uid" value="@if(Auth::check()){{Auth::user()->id}}@endif" hidden>
               <!-- Preventing spam submitted through forms -->
                <x-honeypot /> 	
                <!--  -->
                <h6 class="mb-4">Create Task</h6>
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
                   @foreach($projects as $project)
                      <option value="{{$project->id}}">{{$project->name}}</option>
                   @endforeach
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
               <span id="createButton">
                 <button type="button" id="createTask" class="btn btn-primary">Create Task</button>
                 <button type="button" id="editTask" class="btn btn-primary">Edit Task</button>
                 <button type="button" id="deleteTask" class="btn btn-primary">Delete Task</button>
              </span> 
           </form>
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
