$(document).ready(function () {
  
  
      $("#deleteTask").click(function(e) {
          e.preventDefault();
        $token = $("input[name='_token']").val();
        $uid = $("input[name='uid']").val();
        $taskId = $("input[name='taskId']").val();
  
          var settings = {
              "url": "/delete/task",
              "method": "POST",
              "timeout": 0,
              "headers": {
                "Accept": "application/json",
                "X-CSRF-TOKEN": $token,
                "Content-Type": "application/json"
              },
              "data": JSON.stringify({
                "_token": $token,
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
                  $("#successMessage").delay(2500).fadeOut('slow');
              }else{
                  $('.alert').addClass('alert alert-success');
                  $('#message').html(response['message']); 
                  $('#successMessage').show();
                  $("#successMessage").delay(2500).fadeOut('slow');
                  
                  $('table#manageTask tr#'+response['id']).remove();

              }
            });
  
      });
    });