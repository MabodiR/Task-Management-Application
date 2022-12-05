<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use Spatie\Honeypot\ProtectAgainstSpam;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

//home page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//list all projects
Route::get('/projects', function () {
    return view('projects');
});

Route::get('list/projects', [App\Http\Controllers\ProjectController::class, 'index']);
Route::get('list/departments', [App\Http\Controllers\ProjectController::class, 'index']);
Route::post('create/project', [App\Http\Controllers\ProjectController::class, 'store'])->middleware(ProtectAgainstSpam::class);
Route::post('login/user', [App\Http\Controllers\HomeController::class, 'Login'])->middleware(ProtectAgainstSpam::class);
Route::post('/logout/user', [App\Http\Controllers\HomeController::class, 'Logout'])->middleware(ProtectAgainstSpam::class);

//list tasks
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'tasks']);
Route::get('/manage-tasks', [App\Http\Controllers\TaskController::class, 'managetasks']);
Route::get('list/tasks', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('list/my-tasks', [App\Http\Controllers\TaskController::class, 'mytasks']);
Route::get('get/task/{id}', [App\Http\Controllers\TaskController::class, 'show']);
Route::get('single-task/{id}', [App\Http\Controllers\TaskController::class, 'show']);
Route::get('my-task/{id}', [App\Http\Controllers\TaskController::class, 'showtask']);
Route::get('task/{id}', [App\Http\Controllers\TaskController::class, 'showtask']);
Route::get('list/assignees', [App\Http\Controllers\TaskController::class, 'assignees']);
Route::post('create/task', [App\Http\Controllers\TaskController::class, 'store']);
Route::post('reassign', [App\Http\Controllers\TaskController::class, 'reassign']);

//create comment
Route::post('create/comment', [App\Http\Controllers\CommentController::class, 'store']);

Route::get('edit/task/{id}', [App\Http\Controllers\TaskController::class, 'edit']);
Route::post('delete/task', [App\Http\Controllers\TaskController::class, 'delete']);

Route::post('update/task', [App\Http\Controllers\TaskController::class, 'update']);
Route::post('update/task/status', [App\Http\Controllers\TaskController::class, 'updatestatus']);

Route::get('project/{id}', [App\Http\Controllers\ProjectController::class, 'show']);

Route::get('/my-tasks', [App\Http\Controllers\TaskController::class, 'showmytasks']);