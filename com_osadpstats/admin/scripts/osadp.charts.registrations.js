/**
* @params registrationsCurrent = object from our html.php for registrations this year
* @params registrationsPrevious = object from our html.php for registrations last year
*/
window.OSADP = window.OSADP || {};
window.OSADP.registrationsChart = function ( container, registrationsCurrent, registrationsPrevious ) {
	var arrCurrentRegistrations = [];
	var arrPreviousRegistrations = [];
	for(var x = 0, len = registrationsCurrent.length; x < len; x++) {
		arrCurrentRegistrations.push( parseInt(registrationsCurrent[x].registrations) );
        arrPreviousRegistrations.push( parseInt(registrationsPrevious[x].registrations) );
	}
	var container = $(container);

    container.highcharts({
        chart: {
            type: 'line'
        },
        colors: ['rgb(38, 194, 129)', '#aaa'],
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Downloads'
            }
        },
        legend: {
        	enabled: true
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
            name: new Date().getFullYear(),
            data: arrCurrentRegistrations
        }, {
            name: new Date().getFullYear() - 1,
            data: arrPreviousRegistrations
        }]
    });
}