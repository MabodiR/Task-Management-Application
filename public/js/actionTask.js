
$(document).ready(function () {
    
    $('#editTask').hide();  
    $('#deleteTask').hide(); 

$(".action").change(function(e) {

  var optionSelected = $(this).find("option:selected");
  var id  = optionSelected.val();
  var action   = optionSelected.text();
      
  //get all users
    $.ajax({ 
      type: "GET",
      url: "/get/task/"+id,             
      dataType: "json",              
      success: function(response){    
          
          $('#title').val(response['task'].title);
          $('#hidenTaskId').val(response['task'].id);
          $('#description').val(response['task'].description);                                      
          $('#projects').prepend("<option value='"+response['task'].project['id']+"' selected>"+response['task'].project['name']+"</option>");
          $('#assignees').prepend("<option value='"+response['task'].assignee['id']+"' selected>"+response['task'].assignee['name']+"</option>");
          $('#assignee').val(response['task'].assignee_id);
          
          if(action=="Edit"){
              if($('#createTask').length){
                $('#editTask').show();  
                $('#createTask').hide();  
                $('#deleteTask').hide();  
              }
          }
          if(action=="Delete"){
              if($('#createTask').length){
                $('#deleteTask').show();  
                $('#createTask').hide();  
                $('#editTask').hide(); 
              }
          }
          }
     });  

    });   
});
  