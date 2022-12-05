$(document).ready(function () {
  
    function status(value){
      if(value =='complete'){
         return "<button class='btn btn-sm'><i style='color:green' class='fa fa-check'></i></button>";
      }else{
         return "<button class='btn btn-sm'><i class='fa fa-spinner'></i></button>";
      }
     }
  
      $("#editTask").click(function(e) {
          e.preventDefault();
        $token = $("input[name='_token']").val();
        $title = $("input[name='title']").val();
        $uid = $("input[name='uid']").val();
        $taskId = $("input[name='taskId']").val();
        $description= $("textarea[name='description']").val();     
        $project= $("select[name='project']").val();
        $assignee= $("select[name='assignee']").val();
  
          var settings = {
              "url": "/update/task",
              "method": "POST",
              "timeout": 0,
              "headers": {
                "Accept": "application/json",
                "X-CSRF-TOKEN": $token,
                "Content-Type": "application/json"
              },
              "data": JSON.stringify({
                "title": $title,
                "_token": $token,
                "description": $description,
                "assignee": $assignee,
                "project": $project,
                "uid": $uid,
                "taskId": $taskId
              }),
            };
          
            $.ajax(settings).done(function (response) {
               $('.alert').removeClass('alert-danger');
               $('.alert').removeClass('alert-success');
             
              if (response['status']=="fail"){
                  $('.alert').addClass('alert alert-danger');
                  $('#message').html(response['message']);  
                  $('#successMessage').show();
              }else{
                  $('.alert').addClass('alert alert-success');
                  $('#message').html(response['message']); 
                  $('#successMessage').show();
                  $("#successMessage").delay(2500).fadeOut('slow');
                  
                  $('table#manageTask tr#'+response['task'].id).remove();

                  $(".taskLists").prepend("<tr id='"+response['task'].id+"'>"+
                  "<th scope='row' ><a href='/task/"+response['task'].id+"'>"+response['task'].id+"</a></th>"+
                  "<td>"+response['task'].title+"</td>"+
                  "<td>"+response['task'].description.slice(0, 40)+'...'+"</td>"+
                  "<td>"+response['task'].project['name']+"</td>"+
                  "<td><img class='rounded-circle' src='../img/user.png' alt='' style='width: 20px; height: 20px;'> " +response['task'].assignee['name']+"</td>"+
                  "<td>"+status(response['task'].status)+"</td>"+
                  "<td><select class='form-select form-select-sm action' aria-label=''.form-select-sm example'>"+
                  "<option selected>-</option>"+
                  "<option value='Edit' id='"+response['task'].id+"'>Edit</option>"+
                  "<option value='Delete' id='"+response['task'].id+"'>Delete</option>"+
                  "</select>"+
                  "</tr>");
              }
            });
  
      });
    });