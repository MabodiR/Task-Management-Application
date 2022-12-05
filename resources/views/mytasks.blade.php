@extends('layouts.app')

@section('content')


<!-- Tasks List -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">

    <div class="col-12">
    <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Tasks</h6>
         <!-- success message -->
         <div class="alert" id="successMessageU" role="alert">
            <span id="message"></span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Project</th>
                        <th scope="col">Assignee</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                <tr>
                <th scope='row'><a href='/task/{{$task->id}}'>{{$task->id}}</a></th>
                <td>{{$task->title}}</td>
                <td>{{ substr($task->description, 0,  50) }}...</td>
                <td>{{$task->project['name']}}</td>
                <td><img class='rounded-circle' src='../img/user.png' alt='' style='width: 20px; height: 20px;'> {{$task->assignee['name']}}</td>
                <td>@if($task->status =='complete')
                      <button class='btn btn-sm'><i style='color:green' class='fa fa-check'></i></button>
                    @else
                      <button class='btn btn-sm'><i class='fa fa-spinner'></i></button>
                    @endif</td>
                <td><form method="POST" >
                 <input  type="text" id="token" name="_token" value="{{csrf_token()}}" hidden>
                     <select class="form-select status" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option value="{{$task->id}}" selected>{{$task->status}}</option>
                            <option value="{{$task->id}}">complete</option>
                            <option value="{{$task->id}}">In-Progress</option>
                      </select>
                 </form>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
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
