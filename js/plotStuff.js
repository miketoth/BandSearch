$(document).ready(function(){
    $("#submitButton").click(function () {
        $.getJSON('parse.php',{'artist': $("#artist").val()}, function(response){
            console.log(response);

            // do stuff with response
            $("body").append("<strong> WORD: " + response[0]['name'] + "</strong>");
        });
    });
});


