$(document).ready(function() {              

    //get all users
      $.ajax({ 
        type: "GET",
        url: "/list/assignees",             
        dataType: "json",              
        success: function(response){    
            var users = "";
            response['assignees'].forEach((q) =>{
              users +="<option value="+q.id+">"+q.name+"</option>"
            });
                                      
            $(".assignees").append(users);
            }
      });  
});