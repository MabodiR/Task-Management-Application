$(document).ready(function () {
  
    function status(value){
      if(value =='complete'){
         return "<button class='btn btn-sm'><i style='color:green' class='fa fa-check'></i></button>";
      }else{
         return "<button class='btn btn-sm'><i class='fa fa-spinner'></i></button>";
      }
     }
  
      $("#createComment").click(function(e) {
          e.preventDefault();
        $token = $("input[name='_token']").val();
        $taskId = $("input[name='taskId']").val();
        $uid = $("input[name='uid']").val();
        $comment= $("input[name='comment']").val();     
  
          var settings = {
              "url": "/create/comment",
              "method": "POST",
              "timeout": 0,
              "headers": {
                "Accept": "application/json",
                "X-CSRF-TOKEN": $token,
                "Content-Type": "application/json"
              },
              "data": JSON.stringify({
                "task_id": $taskId,
                "_token": $token,
                "comment": $comment,
                "user_id": $uid,
              }),
            };
          
            $.ajax(settings).done(function (response) {
               $('.alert').removeClass('alert-danger');
               $('.alert').removeClass('alert-success');
              
              if (response['status']=="fail"){
                  $('.alert').addClass('alert alert-danger');
                  $('#message').html(response['message']);  
                  $('#successMessageC').show();
              }else{
                  $('.alert').addClass('alert alert-success');
                  $('#message').html(response['message']); 
                  $('#successMessageC').show();
                  $("#successMessageC").delay(2500).fadeOut('slow');

              console.log(response['comment']);
                  $(".displayComment").prepend("<div class='d-flex align-items-center border-bottom py-3 mt-4'>"+
                    "<img class='rounded-circle flex-shrink-0' src='../img/user.png' alt='' style='width: 40px; height: 40px;'>"+
                    "<div class='w-100 ms-3'>"+
                        "<div class='d-flex w-100 justify-content-between'>"+
                            "<h6 class='mb-0'>"+response['comment'].user['name']+"</h6>"+
                            "<small><time>0 Second ago</time></small>"+
                        "</div>"+
                        "<span>"+response['comment'].comment+"</span>"+
                    "</div>"+
                "</div>");
              }
            });
  
      });
    });