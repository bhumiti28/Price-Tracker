$(document).ready(function() {

	$.ajax({
		url : "localhost/DBMS_project/db_chart.php",
		type : "GET",
		success : function(data){
			console.log(data);

			var prod = {
                price : [],
                date : []
            };
            
			var len = data.length;

			for (var i = 0; i < len; i++) {
                prod.price.push(data[i].price);
                prod.date.push(data[i].date_of_price_changing);
                console.log(prod.date[i]);
                console.log(prod.price[i]);
    
            }

			var ctx = $("#line-chartcanvas");

			var xyz = {
				labels : prod.date,
				datasets : [
					{
						label : "Trends in Prices for Product is : ",
						data : prod.price,
						backgroundColor : "blue",
						borderColor : "lightblue",
						fill : false,
						lineTension : 0,
						pointRadius : 5
					}
				]
			};

			var options = {
				title : {
					display : true,
					position : "top",
					text : "Line Graph",
					fontSize : 18,
					fontColor : "#111"
				},
				legend : {
					display : true,
					position : "bottom"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            max: Math.floor(Math.max(prod.price)*1.2),
                            min: Math.floor(Math.min(prod.price)*0.8)
                        }
                    }]
                }
			};

			var chart = new Chart( ctx, {
				type : "line",
				data : xyz,
				options : options
			});
		},
		error : function(data) {
		}
	});
});