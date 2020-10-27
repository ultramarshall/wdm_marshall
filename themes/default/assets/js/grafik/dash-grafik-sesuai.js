$(function () {
    $('#prop_perda').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: title
        },
        subtitle: {
            text: sub_title
        },
        xAxis: {
            categories: category,
            crosshair: true,
			labels: {
                rotation: rota,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Rainfall (mm)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
				cursor: 'pointer',
                    dataLabels: {
                    enabled: false,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                    },
                     point: {
	                    events: {
		                    click: function() {
								console.log(this.options);
		                        if(this.options.url){
		                            window.open(this.options.url,'_self');
								}
							}
		                }
		            }
            }
        },
        series: data
    });
});

$(function () {
    $('#prop_sesuai').highcharts({
		credits: {
		      enabled: false
		    },
        chart: {
            type: 'column'
        },
        title: {
            text: title_sesuai
        },
		subtitle: {
            text: sub_title_sesuai
        },
        xAxis: {
            categories: category_sesuai,
			crosshair: true,
			labels: {
                rotation: rota,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
       
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: data_sesuai
    });
});