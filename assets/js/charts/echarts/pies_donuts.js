$(function() {

    // Set paths
    // ------------------------------

    require.config({
        paths: {
            echarts: 'assets/js/plugins/visualization/echarts'
        }
    });

    var basic_pie;

    // Configuration
    // ------------------------------

    require(
        [
            'echarts',
            'echarts/theme/limitless',
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],
        // Charts setup
        function(ec, limitless) {


            // Initialize charts
            // ------------------------------
            basic_pie = ec.init(document.getElementById('pie_timeline'), limitless);


            // Charts setup
            // ------------------------------

            //
            // Pie timeline options
            //

            basic_pie_options = {

                // Add title
                title: {
                    text: 'Malware statistics',
                    subtext: 'Based on connections',
                    x: 'center'
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a}: {b}<br/>Count: {c} ({d}%)"
                },

                // Add legend
                // legend: {
                //     x: 'left',
                //     orient: 'vertical',
                //     data: pie_legend_data
                // },


                // Display toolbox
                toolbox: {
                    show: true,
                    x: 'right',
                    orient: 'horizontal',
                    feature: {
                        magicType: {
                            show: true,
                            title: {
                                pie: 'Switch to pies',
                                funnel: 'Switch to funnel',
                            },
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 1700
                                }
                            }
                        },
                        restore: {
                            show: true,
                            title: 'Restore'
                        },
                        saveAsImage: {
                            show: true,
                            title: 'Same as image',
                            lang: ['Save']
                        }
                    }
                },

                // Add series
                series: [{
                    name: 'Malware',
                    type: 'pie',
                    center: ['50%', '50%'],
                    radius: '50%',
                    data: pies_series_data
                }]

            };

            // Apply options
            // ------------------------------

            basic_pie.setOption(basic_pie_options);

            // Resize charts
            // ------------------------------

            window.onresize = function() {
                setTimeout(function() {
                    basic_pie.resize();
                }, 200);
            }


        }
    );
    var get_malware_data = function() {
            $.ajax({
                url: $('base').attr('href') + 'index.php/home/get_malware_data',
                dataType: 'json',
                type: 'get',
                success: function(data) {
                    var pies_series_data = [];
                    for (var i = 0; i < data.length; i++) {
                        var _name = data[i].name.split(/\s+/).slice(0, 5).join(" ");
                        pies_series_data.push({
                            value: data[i].revision,
                            name: _name
                        });
                    }
                    var my_series = [{
                        name: 'Malware',
                        type: 'pie',
                        center: ['60%', '60%'],
                        radius: '60%',
                        data: pies_series_data
                    }];
                    basic_pie.setSeries(my_series, true);
                    basic_pie.restore();
                    clearInterval('get_malware_dataInterval');
                }
            });
        },
        get_malware_dataInterval = setInterval(get_malware_data, 60000);
});
