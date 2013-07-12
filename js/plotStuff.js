$(document).ready(function(){
    $("#submitButton").click(function () {

        $.getJSON('../BandSearch/parse.php', {'artist': $("#artist").val()}, function(response){

        var width = 960;
        var height = 500;

        var svg = d3.select("body").append("svg")
        			.attr("width", width)
        			.attr("height", height);

        	// Put D3 stuff here!
		var circles = svg.selectAll("circle")
		    .data(response)
		  	.enter().append("circle");

		circles.attr("cx", function(d, i) {return (i * 50) + 25;})
			.attr("cy", function() {return 25;})
			.attr("r", function() {return 10;});

        });
    });
});


