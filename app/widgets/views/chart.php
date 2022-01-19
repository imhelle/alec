<?php
/** @var $allDrugCoordinates array */
/** @var $allControlsCoordinates array */

use yii\web\JsExpression;

echo \dosamigos\chartjs\ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 400,
        'width' => 900,
        'id' => 'alecChart'
    ],
    'clientOptions' => [
        'layout' => [
            'padding' => [
                'top' => 5
            ]
        ],
        'scales' => [
            'xAxes' => [[
                'type' => 'linear',
                'display' => 'true',
                'scaleLabel' => [
                    'display' => true,
                    'labelString' => 'Lifespan',
                    'fontSize' => 16
                ],
                'ticks' => [
                    'min' => 0,
                    'max' => 1600,
                ],
            ]],
            'yAxes' => [[
                'scaleLabel' => [
                    'display' => true,
                    'labelString' => 'Survival',
                    'fontSize' => 16,
                    'backdropPaddingX' => 0,
                    'padding' => 0
                ],
                'ticks' => [
                    'min' => 0,
                    'max' => 105,
                    'backdropPaddingX' => 0,
                    'callback' => new JsExpression(
                        "function(value, index, values) { return (index == 0) ? undefined : value + ' % '}
                                "
                    )
                ],
            ]],
        ],
//                'legendCallback' => new JsExpression(
//                    <<< JS
//chart => {
//  let html = '<ul>';
//  // alert(1);
//  chart.data.datasets.forEach((ds, i) => {
//    html += '<li>' +
//      '<span style="width: 14px; height: 14px; background-color:' + ds.backgroundColor + '; border: 2px solid ' + ds.borderColor + '" onclick="onLegendClicked(event, \'' + i + '\', chartJS_alecChart)">&nbsp;</span>' +
//      '<span id="legend-label-' + i + '" onclick="onLegendClicked(event, \'' + i + '\', chartJS_alecChart)">' +
//      ds.label + '</span>' +
//      '</li>';
//  });
//  return html + '</ul>';
//}
//JS
//                ),
        'legend' => [
            'position' => 'chartArea',
            'align' => 'end',
            'labels' => [
                'boxWidth' => 20,
                'filter' => new JsExpression(
                    "function(item, chart) {
                                return !item.text.includes('special_median_line');
                            }"
                ),
            ],
            'fullWidth' => false,
        ],
//                'legendTemplate' => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
        'tooltips' => [
            'callbacks' => [
                'title' => new JsExpression(
                    "function(tooltipItem, data) {
                    console.log(Math.round(tooltipItem[0].yLabel * 100) / 100);
                                return Math.round(tooltipItem.yLabel * 100) / 100;
                            }"
                ),
                'label' => new JsExpression(
                    "function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += tooltipItem.xLabel;
                                return label;
                            }"
                ),
            ]
        ],
        'animation' => false
    ],
    'data' => [
        'datasets' => [
            [
                'label' => 'special_median_line',
                'backgroundColor' => "rgba(198, 93, 87, 0)",
                'borderColor' => "rgba(198, 198, 198, 1)",
                'pointBackgroundColor' => "rgba(198, 198, 198, 1)",
                'pointBorderWidth' => 0,
                'pointRadius' => 1,
                'pointHoverRadius' => 4,
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(198, 198, 198, 1)",
                'data' => [['x' => 0, 'y' => 50], ['x' => 1600, 'y' => 50]],
                'borderDash' => [5, 5],
                'borderWidth' => 1,
                'steppedLine' => true,
            ],
            [
                'label' => "All Controls",
                'backgroundColor' => "rgba(125, 201, 209, 0)",
                'borderColor' => "rgba(125, 201, 209, 1)",
                'pointBackgroundColor' => "rgba(125, 201, 209, 1)",
                'pointBorderWidth' => 0,
                'pointRadius' => 1,
                'pointHoverRadius' => 4,
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(125, 201, 209, 1)",
                'data' => $allControlsCoordinates,
                'steppedLine' => true,
            ],
            [
                'label' => "All Drugs",
                'backgroundColor' => "rgba(198, 93, 87, 0)",
                'borderColor' => "rgba(198, 93, 87, 1)",
                'pointBackgroundColor' => "rgba(198, 93, 87, 1)",
                'pointBorderWidth' => 0,
                'pointRadius' => 1,
                'pointHoverRadius' => 4,
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(198, 93, 87, 1)",
                'data' => $allDrugCoordinates,
                'steppedLine' => true,
            ],

        ]
    ]
]);


$this->registerJs(
<<<JS
// $('#js-legend').html(chartJS_alecChart.generateLegend());
chartJS_alecChart.options.legendCallback = function(chart){
  let html = '<ul>';
  // alert(1);
  chart.data.datasets.forEach((ds, i) => {
    html += '<li>' +
      '<span style="width: 14px; height: 14px; background-color:' + ds.backgroundColor + '; border: 2px solid ' + ds.borderColor + '" onclick="onLegendClicked(event, \\'' + i + '\\')">&nbsp;</span>' +
      '<span id="legend-label-' + i + '" onclick="onLegendClicked(event, \\'' + i + '\\')">' +
      ds.label + '</span>' +
      '</li>';
  });
  return html + '</ul>';
}
function shuffle (arr) {
    var j, x, index;
    for (index = arr.length - 1; index > 0; index--) {
        j = Math.floor(Math.random() * (index + 1));
        x = arr[index];
        arr[index] = arr[j];
        arr[j] = x;
    }
    return arr;
}
 let palette = shuffle(['#307691', '#5b75ad', '#8674c8', '#b072e4', '#db71ff', '#e48edd', '#edacbb', '#f6c998', '#ffe676', '#dfd098', '#9ea5dd', '#7e8fff', '#84abfa', '#8ac7f5', '#90e3ef', '#96ffea', '#b0e0cf', '#cac0b4', '#e3a198', '#67bb9f', '#8db077', '#b3a650', '#d99c28', '#ff9200', '#ea842d', '#d5775b', '#c06a88', '#ac5cb5', '#974fe2', '#ff9f1c', '#8593f4', '#7ac0ff', '#8eaacc', '#a29499', '#b67f66', '#ca6933', '#de5300']);
console.log(palette)
 let colors = [
        [11, 181, 255],
        [10, 201, 43],
        [125, 38, 205],
        [139, 117, 0],
        [205, 105, 201],
        [205, 181, 205],
        [229, 188, 59],
        [108, 166, 205],
        [255,99,71],
        [255,160,122],
        [50,205,50],
        [123,104,238],
        [221,160,221],
        [219,112,147],
        [244,164,96],
        [188,143,143],
        [199,21,133],
        [32,178,170],
        [189,183,107],
        [255,215,0],
        [143,188,143],
        [0,206,209],
        [0,0,139],
        [0,0,139],
        [139,0,139],
    ]
    
    function drawChart(data) 
    {
        color = palette[chartJS_alecChart.data.datasets.length];
            console.log(color)
            let newDataset = {
                'label': data.label,
                'backgroundColor': 'rgba(0,0,0,0)',
                'borderColor': color,
                'pointBackgroundColor': color,
                'pointBorderWidth': 0,
                'pointRadius': 1.5,
                'pointHoverRadius': 4,
                'pointHoverBackgroundColor': '#fff',
                'pointHoverBorderColor': color,
                'data': data.coords,
                'steppedLine': true
            }
            chartJS_alecChart.data.datasets.push(newDataset);
            chartJS_alecChart.update();
    }
    
    $(document).on('click', '#clear_data', function() {
        chartJS_alecChart.data.datasets.length = 1;
        chartJS_alecChart.update();
    });
//  'scales' => [
//                    'xAxes' => [[
//                        'type' => 'linear',
//                        'display' => 'true',
//                        'scaleLabel' => [
//                            'display' => true
//                        ],
//                        'max' => 1500
//                    ]],

    $(document).on('change', '#chart_start', function() {
        if($(this).val().length) {
            chartJS_alecChart.options.scales.xAxes[0].ticks.min = parseInt($(this).val());
        } else {
            chartJS_alecChart.options.scales.xAxes[0].ticks.min = null;
        }
        chartJS_alecChart.update();
    });
    $(document).on('change', '#chart_end', function() {
        console.log($(this).val())
        if($(this).val().length) {
            chartJS_alecChart.options.scales.xAxes[0].ticks.max = parseInt($(this).val());
        } else {
            chartJS_alecChart.options.scales.xAxes[0].ticks.max = 1600;
        }
        chartJS_alecChart.update();
    });
    $(document).on('click', '#add_data', function() {
        /** @var chartJS_alecChart */
        let chartCanvas = $('#alecChart')
        chartCanvas.css('opacity', '0.5');
        
        console.log(chartJS_alecChart)
        console.log(window.location.href)

        let parameter = (window.location.href.indexOf("?") > -1) ? '&getCoords=1' : '?getCoords=1'
        $.get(window.location.href + parameter, function(data, status){
            data = JSON.parse(data)
            drawChart(data);
        });
        chartCanvas.css('opacity', '1')
    });
    
    $(document).on('click', '#clear_strains', function() {
    
        console.log(window.location.href)
        var url = new URL(window.location.href);
        var params = new URLSearchParams(decodeURI(url.search));
        console.log(url)
        console.log(params)
//        $('#w1').val(null).trigger('change');
//        $('.form-control.select2-hidden-accessible').val(null).trigger('change');
    });
    
    $(document).on('click', '#download', function() {
        let parameter = (window.location.href.indexOf("?") > -1) ? '&getFile=1' : '?getFile=1'
        console.log(window.location.href)
        document.location = window.location.href + parameter;
    });
    
    $(document).on('change', '#upload_field', async function() {
        var formData = new FormData($('#uploadForm')[0]);
        await new Promise(r => setTimeout(r, 1000));
        $.ajax({
            url: "/site/upload",  
            type: 'POST',
            data: formData,
    
            success: function(response) {
                data = JSON.parse(response)
                console.log(data);
                $("#upload_error").remove();
                if (data.error) {
                    $('#uploadForm').append("<span id='upload_error'>"+data.error+"</span>")
                } else {
                    drawChart(data);
                }
            },

            error: function(){
                $('#uploadForm').append("<span id='upload_error'>Something went wrong</span>")
            },

            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
    });
    });
    

    
JS

);