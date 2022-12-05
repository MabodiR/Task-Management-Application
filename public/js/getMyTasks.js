$(document).ready(function() {              

    function status(value){
        if(value =='complete'){
           return "<button class='btn btn-sm'><i style='color:green' class='fa fa-check'></i></button>";
        }else{
           return "<button class='btn btn-sm'><i class='fa fa-spinner'></i></button>";
        }
    }

    //get all projects
      $.ajax({ 
        type: "GET",
        url: "/list/my-tasks",             
        dataType: "json",              
        success: function(response){    
            var template = "";
           
            response['tasks'].forEach((q) =>{
        template +=
                "<tr>"+
                "<th scope='row'><a href='/my-task/"+q.id+"'>"+q.id+"</a></th>"+
                "<td>"+q.title+"</td>"+
                "<td>"+q.description.slice(0, 40)+'...'+"</td>"+
                "<td>"+q.project['name']+"</td>"+
                "<td><img class='rounded-circle' src='../img/user.png' alt='' style='width: 20px; height: 20px;'> " +q.assignee['name']+"</td>"+
                "<td>"+status(q.status)+"</td>"+
                "<td><select class='form-select form-select-sm action'>"+
                "<option selected>-</option>"+
                "<option value='Edit' data-id='"+q.id+"'>Edit</option>"+
                "<option value='Delete' data-id='"+q.id+"'>Delete</option>"+
                "</select>"+
                "</tr>"});
                                      
            $(".myTaskLists").html(template);
            }
      });  
});