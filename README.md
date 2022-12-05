

## About Task Management

This is a task Management app that allows supervisors to create task for their subordinates and vise versa, subordinates get a mail notification each time a new task is assigned to them, supervisor and subordinates are allowed to manage their task, edit and delete. Supervisor and subordinates have the capabilities to comment on each task and update its status whether complete or still in progress. Each time a user comment on a task, assignor of the task get a mail notification about the comment.

## Features

- **[Registration]**
- **[Login]**
- **[Create Task]**
- **[Edit Task]**
- **[Delete Task]**

- **[Assign Task]**
- **[Re-Assign task]**
- **[Add/Create Project]**
- **[Mail Notification]**


## Instalation Instruction

Requires PHP  >=8.0 
Requires MySQL  8
Requires Apache 

## Steps

- **Run Composer install**
- **Run cp .env.example .env**
- **Run php artisan key:generate**
- **Create Database named taskManagement**
# DB Connection
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=taskManagement
 DB_USERNAME=root
 DB_PASSWORD=
- **Run php artisan migrate**
- **Run php artisan db:seed**
- **Run php artisan serve**

## .env file

## App time zone

APP_TIMEZONE='Africa/Johannesburg'

## Mail Connection 
MAIL_MAILER=smtp
MAIL_HOST=mail.mabodirofhiwa.co.za
MAIL_PORT=465
MAIL_USERNAME=calidad@mabodirofhiwa.co.za
MAIL_PASSWORD="9%RLl_HOyV_l"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=calidad@mabodirofhiwa.co.za
MAIL_FROM_NAME="${APP_NAME}"

## Users

'email' => 'subordinate1@calidad.co.za',
'role' => 'subordinate'
'password' => 'password'

'email' => 'supervisor@calidad.co.za',
'role' => 'supervisor'
'password' => 'password'


