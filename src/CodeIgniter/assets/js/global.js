$(document).ready(function() {

    $("ul.dropdown-menu a").click(function() {
      event.preventDefault();
      var URL = $(this).attr("href");
      $(".main").empty();
      $(".main").load(URL);      
    });
    
});