$(document).ready(function() {              

    //get all departments
      $.ajax({ 
        type: "GET",
        url: "/list/departments",             
        dataType: "json",              
        success: function(response){    
            var dept = "";
            response['departments'].forEach((q) =>{
              dept +="<option value="+q.id+">"+q.name+"</option>"
            });
                                      
            $("#department").append(dept);
            }
      });  
});