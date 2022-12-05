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
        url: "/list/comments",             
        dataType: "json",              
        success: function(response){    
            var comments = "";
           
            response['comments'].forEach((q) =>{
        comments +="<img class='rounded-circle flex-shrink-0' src='../img/user.png' alt='' style='width: 40px; height: 40px;'>"+
                    "<div class='w-100 ms-3'>"+
                        "<div class='d-flex w-100 justify-content-between'>"+
                            "<h6 class='mb-0'>"+q.user['name']+"</h6>"+
                            "<small><time>0 Second ago</time></small>"+
                        "</div>"+
                        "<span>"+q.comment+"</span>"+
                    "</div>"+
                "</div>"});
                                      
            $(".displayComment").html(comments);
            }
      });  
});