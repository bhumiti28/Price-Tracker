$(document).ready(function(){
    var ctx= $("#bar-chartcanvas");

    var data = {
        labels : ["match 1", "match 2", "match 3", "match 4", "match 5"],
        datasets:[
            {
                label : "Team-A  score",
                data : [10, 40, 50, 25, 35],
                backgroundColor :[
                    "rgba(10, 20, 30, 0.3)",    
                    "rgba(10, 20, 30, 0.3)",
                    "rgba(10, 20, 30, 0.3)",
                    "rgba(10, 20, 30, 0.3)",
                    "rgba(10, 20, 30, 0.3)",
                ],
                borderColor : [
                    "rgba(10, 20, 30, 1)",    
                    "rgba(10, 20, 30, 1)",
                    "rgba(10, 20, 30, 1)",
                    "rgba(10, 20, 30, 1)",
                    "rgba(10, 20, 30, 1)",
                ],
                borderWidth : 1
            },
            {
                label : "Team-A  score",
                data : [40, 20, 10, 75, 15],
                backgroundColor :[
                    "rgba(50, 100, 150, 0.3)",    
                    "rgba(50, 100, 150, 0.3)",
                    "rgba(50, 100, 150, 0.3)",    
                    "rgba(50, 100, 150, 0.3)",
                    "rgba(50, 100, 150, 0.3)",
                ],
                borderColor : [
                    "rgba(50, 100, 150, 1)",    
                    "rgba(50, 100, 150, 1)",
                    "rgba(50, 100, 150, 1)",    
                    "rgba(50, 100, 150, 1)",
                    "rgba(50, 100, 150, 1)",
                ],
                borderWidth : 1
            }
        ]
    };

    var options = {
        title : {
            display: true,
            position : "top",
            text : "Bar Graph",
            fontSize : 18,
            fontColor : "#111"
        },
        legend :{
            display : true,
            position : "bottom"
        },
        scales :{
            yAxes :[{
                ticks : {
                    min : 0,
                    max : 100
                }
            }]
        }
    }

    var chart = new Chart(ctx,{
        type : "bar",
        data : data,
        options : options
    }); 
});