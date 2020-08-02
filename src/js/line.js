$(document).ready(function(){
    var ctx = $("#line-chartcanvas");

    var data = {
        labels : ["match-1", "match-2", "match-3", "match-4", "match-5"],
        datasets : [{
            label : "Team-A Score",
            data : [10 , 50, 25, 70, 40],
            backgroundColor : "blue",
            borderColor : "lightblue",
            fill : false,
            lineTension : 0,
            pointRadius : 5
        },
        {
            label : "Team-B Score",
            data : [50, 10, 75, 20, 90],
            backgroundColor : "yellow",
            borderColor : "orange",
            fill : false,
            lineTension : 0,
            pointRadius : 5
        }
    ]};
    
    var options = {
        title :{
            display : true,
            position : "top",
            text : "Line Graph",
            fontSize : 18,
            fontColor : "#111"
        },
        legend :{
            display : true,
            position : "bottom"
        },
        scales :{
            yAxes : [{
                ticks : {
                    min : 0,
                    max : 120
                }
            }]
        }
    };

    var chart = new Chart ( ctx, {
        type : "line",
        data : data,
        options : options
    }); 
});