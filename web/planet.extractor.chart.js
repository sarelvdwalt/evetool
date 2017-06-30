$(".extraction-chart").click(function () {
    var $el = $(this);

    console.log($el.data('id'));

    $.ajax({
        url: "/api/extractor/" + $el.data('id') + "/chartdata"
    }).done(
        function(data) {
            console.log(data);

            while (theAllSeeingChart.series.length) {
                theAllSeeingChart.series[0].remove();
            }

            theAllSeeingChart.colorCounter = 0;
            theAllSeeingChart.addSeries({
                data: data.values,
                name: 'Yield'
            });

            theAllSeeingChart.xAxis[0].removePlotLine('plot-line-NOW');
            if (typeof data.plotLineNOW !== 'undefined') {
                theAllSeeingChart.xAxis[0].addPlotLine({
                    color: 'white',
                    value: data.plotLineNOW,
                    width: 1,
                    id: 'plot-line-NOW',
                    zIndex: 99999,
                    label: 'Current time.'
                });
            }

            theAllSeeingChart.setTitle({
                text: $el.data('toon')
            });

            theAllSeeingChart.setSubtitle({
                text: 'Percentiles [95th = ' + data.perc95th + ' | 66th = ' + data.perc66th + ' | 33rd = ' + data.perc33th + ']'
            });
        }
    );
});


var theAllSeeingChart = Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Quantity Extraction'
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
        series: {
            animation: {
                duration: 200
            }
        }
    },
    series: [{
        name: "Yield",
        data: []
    }]
});
