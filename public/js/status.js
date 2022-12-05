
$(document).ready(function () {

$(".status").change(function(e) {

  var optionSelected = $(this).find("option:selected");
  var id  = optionSelected.val();
  var action   = optionSelected.text();
  $token = $("input[name='_token']").val();

  var settings = {
    "url": "/update/task/status",
    "method": "POST",
    "timeout": 0,
    "headers": {
      "Accept": "application/json",
      "X-CSRF-TOKEN": $token,
      "Content-Type": "application/json"
    },
    "data": JSON.stringify({
      "action": action,
      "id": id,
    }),
  };

  $.ajax(settings).done(function (response) {
     $('.alert').removeClass('alert-danger');
     $('.alert').removeClass('alert-success');
   
    if (response['status']=="fail"){
        $('.alert').addClass('alert alert-danger');
        $('#message').html(response['message']);  
        $('#successMessageU').show();
        $("#successMessageU").delay(2500).fadeOut('slow');
    }else{
        $('.alert').addClass('alert alert-success');
        $('#message').html(response['message']); 
        $('#successMessageU').show();
        $("#successMessageU").delay(2500).fadeOut('slow');
        
    }
  });
 

    });   
});
  