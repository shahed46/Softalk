 
//for hiding and showing login & register form


 $(document).ready(function(){

$("#signup").click(function(){
    $("#first").slideUp("fast", function(){
    	$("#second").slideDown("fast");
    });
});

$("#signin").click(function(){
  $("#second").slideUp("fast", function(){
  	$("#first").slideDown("fast");
  });
});


});