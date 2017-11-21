<!DOCTYPE html>
<html>
<head>
    <title>Mes Temperatures</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
 
</head>
 
<body>
 

 
<div id="graphique0"></div>
 
<script type="text/javascript">
//**ceci est du code Highcharts.com*************************************************************************
//** vous pouvez trouver toutes les decriptions des options sur le site officiel****************************
// temperature 
$(function() {
    chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'graphique0',
            type: 'spline',
            zoomType: 'x',
            backgroundColor: null,
        },
        title: {
            text: 'Temperatures',
            style:{
                color: '#4572A7',
            },
        },
        legend: {
            enabled: true,
            backgroundColor: 'white',
            borderRadius: 14,
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { 
                month: '%e. %b',
                year: '%b',
            }
         },
        yAxis: [{ 
            labels: {
                format: '{value} °C',
                style: {
                    color: '#C03000',
                },
            },
            title: {
                text: '',
                style: {
                    color: '#C03000',
                },
            }
        }],
        tooltip: {
            shared: true,
            crosshairs: true,
            borderRadius: 6,
            borderWidth: 3,
            xDateFormat: '%A %e %b  %H:%M:%S',
            valueSuffix: ' °C',
         },
        plotOptions: {
            spline: {
                marker: {
                    enabled: false, 
                },
            },
        },
 
        series: [{
            name: 'sonde1',
            color: 'red',
            zIndex: 1,
            data: [<?php echo $liste1; ?>] // c'est ici qu'on insert les data
        }, {
            name: 'sonde2',
            color: 'blue',
            zIndex: 2,
            data: [<?php echo $liste2; ?>] // c'est ici qu'on insert les data
        }]
    });
});
</script>
 
</body>
</html>