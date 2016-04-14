/**
* @params a = object from our html.php for registrations this year
* @params b = object from our html.php for registrations last year
*/
window.OSADP = window.OSADP || {};
window.OSADP.topDownloadsChart = function ( container, items ) {
		var labels = [];
		var dataset = [];
		for( var x = 0; x < 5; x ++ ) {
			labels.push(items[x].title);
			dataset.push(parseInt(items[x].hits));
		}
		var container = $(container);
        container.highcharts({
            chart: {
                type: 'bar'
            },
            colors: ['rgb(129, 207, 224)'],
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: labels
            },
            yAxis: {
                title: {
                    text: 'Downloads'
                }
            },
            legend: {
            	enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
            	name: '',
                dataLabels: {
                    enabled: true
                },
            	data: dataset
            }]
        });
}