$(document).ready(function(){
    $("#submitButton").click(function () {
    	console.log("plz");
    	console.log($("#artist").val());

        $.getJSON('../BandSearch/parse.php', {'artist': $("#artist").val()}, function(response){

            // do stuff with response
            $("body").append("Success!");
            $("body").append("<strong> WORD: " + response[0]['name'] + "</strong>");
        });
    });
});


