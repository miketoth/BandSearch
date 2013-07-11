$(document).ready(function(){
    $("#submitButton").click(function () {

        $.getJSON('../BandSearch/parse.php', {'artist': $("#artist").val()}, function(response){

        console.log(response);

        var width = 960;
        var height = 500;

        var svg = d3.select("body").append("svg")
        			.attr("width", width)
        			.attr("height", height)

        	// Put D3 stuff here!
		d3.select("body").selectAll("p")
		    .data(response)
		  	.enter()
		  	.append("p")
		    .text(function(response) { return response['name']; });

		var node = svg.selectAll(".node")
					.data(response)
				.enter().append("circle")
					.attr("class", "node")
					.attr("r", 30)
					.attr("cx", 100)
					.attr("cy", 50)
					.attr("stroke","black")
					.attr("fill", "white");

		/*		
		node.append("text")
			.data(response)
			.attr("dx", 100)
			.attr("dy", 100)
			.text(function(response) {return response['name']; });
			*/


        });
    });
});


