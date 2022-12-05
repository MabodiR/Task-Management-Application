$(document).ready(function () {
    $('#successMessage').hide();

    $("#createProject").click(function(e) {
        e.preventDefault();
      $token = $("input[name='_token']").val();
      $name = $("input[name='name']").val();
      $description= $("textarea[name='description']").val();     
    
        var settings = {
            "url": "/create/project",
            "method": "POST",
            "timeout": 0,
            "headers": {
              "Accept": "application/json",
              "X-CSRF-TOKEN": $token,
              "Content-Type": "application/json"
            },
            "data": JSON.stringify({
              "name": $name,
              "_token": $token,
              "description": $description,
            }),
          };
        
          $.ajax(settings).done(function (response) {
             $('.alert').removeClass('alert-danger');
             $('.alert').removeClass('alert-success');
            if (response['status']=="fail"){
                $('.alert').addClass('alert alert-danger');
                $('#message').html(response['message']);  
                $('#successMessageP').show();
            }else{
                $('.alert').addClass('alert alert-success');
                $('#message').html(response['message']); 
                $('#successMessageP').show();
                $("#successMessageP").delay(2500).fadeOut('slow');

                $(".projectLists").prepend("<div class='col-sm-12 col-xl-6 mt-4 mb-2' >"+
                "<div class='bg-secondary rounded h-100 p-4'>"+
                    "<h6 class='mb-4'><a href='/project/"+response['task'].id+"'>"+response['task'].name+"</a></h6>"+
                    "<nav>"+
                        "<div class='nav nav-tabs' id='nav-tab' role='tablist'>"+
                            "<button class='nav-link active' id='nav-home-tab' data-bs-toggle='tab'"+
                                "data-bs-target='#nav-home' type='button' role='tab' aria-controls='nav-home'"+
                                "aria-selected='true'>Description</button>"+
                            " </div>"+
                            "</nav>"+
                            " <div class='tab-content pt-3' id='nav-tabContent'>"+
                            "<div class='tab-pane fade show active' id='nav-home' role='tabpanel' aria-labelledby='nav-home-tab'>"+response['task'].description+
                            "</div>"+
                            "</div>"+
                            "</div>"+
                            "</div>");
            }
          });

    });
  });