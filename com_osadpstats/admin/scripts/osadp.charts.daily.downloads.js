/**
* @params a = object from our html.php for registrations this year
* @params b = object from our html.php for registrations last year
*/
window.OSADP = window.OSADP || {};
window.OSADP.dailyDownloadsChart = function ( container, items, _from, _until ) {
		var labels = [];
		var dataset = [];
        var fromDate = new Date(_from);
        var untilDate = new Date(_until);
        // get the dates in between _from to _until
        var range = this.getRange( fromDate, untilDate );
        var day, downloads;
        // build our dataset with dates and 0 downloads
        for (var i = 0; i < range.length; i++) {
            dataset.push([range[i], 0]);
            range[i] = range[i].getDate();
        }
        // assign the correct number of downloads to an
        // available date from our database
        for (var i = 0; i < dataset.length; i++) {
            var data = dataset[i];
            for (var x = items.length - 1; x >= 0; x--) {
                if( items[x].month == data[0].getMonth() + 1 && items[x].day == data[0].getDate()) {
                    var itemDay = parseInt( items[x].day );
                    downloads = parseInt( items[x].downloads );
                    dataset[i][1] = downloads;
                }
            }
        }
        // build our highchart line chart
		var container = $(container);
        container.highcharts({
            chart: {
                type: 'area'
            },
            colors: ['rgb(210, 77, 87)'],
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                title: {
                    text: 'Date'
                },
                categories: range
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
                dataLabels: {
                    enabled: true
                },
            	name: 'Downloads',
            	data: dataset
            }]
        });
}

window.OSADP.getRange = function(startDate, stopDate) {
    var dateArray = new Array();
    var currentDate = startDate;
    while (currentDate <= stopDate) {
        dateArray.push( new Date (currentDate) )
        currentDate = currentDate.addDays(1);
    }
    return dateArray;
}

Date.prototype.addDays = function(days) {
    var dat = new Date(this.valueOf())
    dat.setDate(dat.getDate() + days);
    return dat;
}