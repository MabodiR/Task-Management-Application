$(document).ready(function () {
    $('#successMessages').hide();
      $("#reAssignTask").click(function(e) {
          e.preventDefault();
        $token = $("input[name='_token']").val();
        $taskId = $("input[name='taskId']").val();
        $assignee= $("select[name='assignee']").val();

          var settings = {
              "url": "/reassign",
              "method": "POST",
              "timeout": 0,
              "headers": {
                "Accept": "application/json",
                "X-CSRF-TOKEN": $token,
                "Content-Type": "application/json"
              },
              "data": JSON.stringify({
                "_token": $token,
                "taskId": $taskId,
                "assignee": $assignee,
              }),
            };
          
            $.ajax(settings).done(function (response) {
               $('.alert').removeClass('alert-danger');
               $('.alert').removeClass('alert-success');
             console.log(response['task'])
              if (response['status']=="fail"){
                  $('.alert').addClass('alert alert-danger');
                  $('#messages').html(response['message']);  
                  $('#successMessages').show();
              }else{
                  $('.alert').addClass('alert alert-success');
                  $('#messages').html(response['message']); 
                  $('#successMessages').show();
                  $("#successMessages").delay(2500).fadeOut('slow');
                  
                  $(".assignedTo").html(response['task'].assignee['name']);
              }
            });
  
      });
    });