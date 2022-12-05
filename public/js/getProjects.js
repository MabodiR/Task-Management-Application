$(document).ready(function() {              

    //get all projects
      $.ajax({ 
        type: "GET",
        url: "/list/projects",             
        dataType: "json",              
        success: function(response){     
            var template = "";
            var projects = "";
            response['project'].forEach((q) =>{
        projects +="<option value="+q.id+">"+q.name+"</option>";       
        template +="<div class='col-sm-12 col-xl-6 mt-3 mb-3' >"+
            "<div class='bg-secondary rounded h-100 p-4'>"+
                "<h6 class='mb-4'><a href='/project/"+q.id+"'>"+q.name+"</a></h6>"+
                "<nav>"+
                    "<div class='nav nav-tabs' id='nav-tab' role='tablist'>"+
                        "<button class='nav-link active' id='nav-home-tab' data-bs-toggle='tab'"+
                            "data-bs-target='#nav-home' type='button' role='tab' aria-controls='nav-home'"+
                            "aria-selected='true'>Description</button>"+
                        
                        " </div>"+
                        "</nav>"+
                        " <div class='tab-content pt-3' id='nav-tabContent'>"+
                        "<div class='tab-pane fade show active' id='nav-home' role='tabpanel' aria-labelledby='nav-home-tab'>"+q.description+
                        "</div>"+
                       
                        "</div>"+
                        "</div>"+
                        "</div>"});
                                      
            $(".projectLists").append(template);
            $(".projects").append(projects);
            }
      });  
});