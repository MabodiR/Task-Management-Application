$(document).ready(function() {              

    function status(value){
        if(value =='complete'){
           return "<button class='btn btn-sm'><i style='color:green' class='fa fa-check'></i></button>";
        }else{
           return "<button class='btn btn-sm'><i class='fa fa-spinner'></i></button>";
        }
    }

    //get all tasks
      $.ajax({ 
        type: "GET",
        url: "/list/tasks",             
        dataType: "json",              
        success: function(response){    
            var template = "";
            
            response['tasks'].forEach((q) =>{
        template +=
                "<tr id='"+q.id+"'>"+
                "<th scope='row'><a href='/my-task/"+q.id+"'>"+q.id+"</a></th>"+
                "<td>"+q.title+"</td>"+
                "<td>"+q.description.slice(0, 40)+'...'+"</td>"+
                "<td>"+q.project['name']+"</td>"+
                "<td><img class='rounded-circle' src='../img/user.png' alt='' style='width: 20px; height: 20px;'> " +q.assignee['name']+"</td>"+
                "<td>"+status(q.status)+"</td>"+
                "<td><div class='nav-item dropdown'>"+
                "<a href='#' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'>Manage</a>"+
                "<div class='dropdown-menu bg-transparents border-0'>"+
                "<a href='/edit/task/"+q.id+"' class='dropdown-item'>Edit</a>"+
                "<a href='/delete/task/"+q.id+"' class='dropdown-item'>Delete</a>"+
                " </div>"+
                "</div>"+
                "</tr>"});
                                      
            $(".taskLists").append(template);
            }
      });  
});