    $(function () {
        $('#panel_lengkap').highcharts({
            credits: {
		      enabled: false
		    },
             chart: {
                type: 'column'
            },
            title: {
                text: title_lengkap,
                x: -20 //center
            },
            subtitle: {
                text: sub_title_lengkap,
                x: -20
            },
            xAxis: {
                categories: category_lengkap,
                labels: {
                    rotation: -90,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }}
            },
            yAxis: {
                min:0,
                max:100,
                title: {
                    text: 'Laporan (%)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                    },
                    point: {
	                    events: {
		                    click: function() {
		                       if(this.options.url){
		                            window.open(this.options.url,'_self');
							   }else{
		                            tbl_detail(this.category);
							   }
							}
		                }
		            }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                enabled: false,
                borderWidth: 0
            },
            series: [{name:'Propinsi',
				data:data_lengkap, 
				dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				x: 4,
				y: 10,
				style: {
					fontSize: '11px',
					fontFamily: 'Verdana, sans-serif',
					textShadow: '0 0 3px black'
				}
				}}
				]
        });
    });