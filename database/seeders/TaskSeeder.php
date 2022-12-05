<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                $supervisor = User::create([
                        'name' =>'Claire Schermeier',
                        'email' => 'supervisor@calidad.co.za',
                        'role' => 'supervisor',
                        'position' => 'Supervisor',
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                    ]);
            
                $subordinate = User::create([
                    'name' =>'Rofhiwa Mabodi',
                    'email' => 'subordinate1@calidad.co.za',
                    'role' => 'subordinate',
                    'position' => 'Supervisor',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]);
            
                $project1 = Project::create(['name' => 'Task Management','description'=>'The great thing about the dashboard is you can also set it up for a company view into projects, project statuses, task progress, and the resource availability at a glance. You can even have multiple company dashboards for different areas of the business if your other departments are using it as well. 

                Comes in handy to see what the sales pipeline is weighing and also your project workload with progress to ensure when the sales team closes that deal, it is already determined when an approximate start date can happen.']);
                $project2 = Project::create(['name' => 'Finance Calculator','description'=>'This calculator provides an estimate on the repayments you can expect when taking a loan.

                There are other factors to consider when doing the actual calculation, items such as fees and dates applicable to the loan.
                
                When taking a loan always ensure that the institution is certified by the Financial Services Board (FSB).']);
            
                $task = new Task([
                    'title' => 'Task Management System',
                    'description' => 'A powerful task management software gives you the best tools when it comes to creating tasks, organizing, assigning, tracking, and reporting on team projects and the required tasks.',
                     'assignee_id'=>$subordinate->id,
                     'assignor_id'=> $supervisor->id,
                     'project_id'=> $project1->id
                ]);
            
                $task->assignor()->associate($supervisor)->save();
                $task->assignee()->associate($subordinate)->save();
                $task->project()->associate($project1);
        
                $comment = new Comment([
                    'comment' => 'User registration is failing, with the below error : ',
                    // 'task_id'=> $task->id
                ]);
        
                $comment->task()->associate($task);
                $comment->user()->associate($supervisor)->save();
    }
}
