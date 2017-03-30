$(function () {

    // Set paths
    // ------------------------------

    require.config({
        paths: {
            echarts: 'assets/js/plugins/visualization/echarts'
        }
    });

    // Configuration
    // ------------------------------
    var chord_non_ribbon;
    require(
        [
            'echarts',
            'echarts/theme/limitless',
            'echarts/chart/funnel',
            'echarts/chart/pie',
            'echarts/chart/chord'
        ],

        // Charts setup
        function (ec, limitless) {

            // Initialize charts
            var chord_non_ribbon = ec.init(document.getElementById('chord_non_ribbon'), limitless);
            var funnel_asc = ec.init(document.getElementById('funnel_asc'), limitless);
            var top_domain = ec.init(document.getElementById('top_domain'), limitless);
            // Charts setup
            // ------------------------------   

            chord_non_ribbon_options = {

                // Add title
                // title: {
                //     text: 'Fußball Bundesliga',
                //     subtext: 'Players effectiveness',
                //     x: 'right'
                // },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: function (params) {
                        if (params.indicator2) { // is edge
                            return params.indicator2 + ': ' + params.indicator;
                        }
                        else { // is node
                            return params.name
                        }
                    }
                },

                // // Add legend
                // legend: {
                //     orient: 'vertical',
                //     x: 'left',
                //     data: legend_data
                // },


                // Add series
                series: [
                    {
                        type: 'chord',
                        sort: 'ascending',
                        sortSub: 'descending',
                        showScale: false,
                        ribbonType: false,
                        radius: '68%',
                        minRadius: 7,
                        maxRadius: 20,
                        itemStyle: {
                            normal: {
                                chordStyle: {
                                    color: '#999'
                                },
                                label: {
                                    rotate: true
                                }
                            }
                        },
                        nodes: nodes_data,
                        links: links_data
                    }
                ]
            };
            

            //
            // Funnel sorting options
            //

            funnel_asc_options = {

                // Add title
                title: {
                    text: 'Top attacked IPs',
                    x: 'center'
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c}%"
                },
                // Add legend
                legend: {
                    x: 'left',
                    y: 75,
                    orient: 'vertical',
                    data: sorting_legend
                },

                // Enable drag recalculate
                // calculable: true,

                // Add series
                series: [
                    {
                        name: 'IP Information',
                        type: 'funnel',
                        x: '25%',
                        x2: '25%',
                        y: '17.5%',
                        height: '80%',
                        sort: 'ascending',
                        itemStyle: {
                            normal: {
                                label: {
                                    position: 'left'
                                }
                            }
                        },
                        data: sorting_data
                    }
                ]
            };


            //
            // Funnel sorting options
            //

            top_domain_option = {

                // Add title
                title: {
                    text: 'Top attacked domains',
                    x: 'center'
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c}%"
                },
                // Add legend
                legend: {
                    x: 'left',
                    y: 75,
                    orient: 'vertical',
                    data: domain_legend
                },

                // Enable drag recalculate
                // calculable: true,

                // Add series
                series: [
                    {
                        name: 'Domain',
                        type: 'funnel',
                        x: '25%',
                        x2: '25%',
                        y: '17.5%',
                        height: '80%',
                        sort: 'ascending',
                        itemStyle: {
                            normal: {
                                label: {
                                    position: 'left'
                                }
                            }
                        },
                        data: domain_data
                    }
                ]
            };

            chord_non_ribbon.setOption(chord_non_ribbon_options);
            funnel_asc.setOption(funnel_asc_options);
            top_domain.setOption(top_domain_option);
            $("#fade-tab2").removeClass('active');
            $("#fade-tab2").removeClass('in');
            // Resize charts
            // ------------------------------

            window.onresize = function () {
                setTimeout(function (){
                    top_domain.resize();
                    funnel_asc.resize();
                    chord_non_ribbon.resize();

                }, 200);
            }
        }
    );
    // var get_domain_connect_data = function() {
    //     $.ajax({
    //         url: $('base').attr('href') + 'index.php/home/get_domain_connect_data',
    //         dataType:'json',
    //         type: 'get',
    //         success: function(data){
    //             var nodes_data = [],links_data = [];
    //             $.ajax({
    //                 url: $('base').attr('href') + 'index.php/home/get_domains',
    //                 dataType:'json',
    //                 type: 'get',
    //                 success: function(domain){
    //                     for (var i = 0; i < domain.length; i++) {
    //                         nodes_data.push({name:domain[i]});
    //                     }
    //                 }
    //             });
    //             for (var i = 0; i < data.length; i++) {
    //                 nodes_data.push({name:data[i].orig_h});
    //                 links_data.push(
    //                     {
    //                         source: data[i].host, 
    //                         target: data[i].orig_h, 
    //                         weight: 0.9, 
    //                         name: 'Effectiveness'
    //                     }
    //                 );
    //                 links_data.push(
    //                     {
    //                         target: data[i].host, 
    //                         source: data[i].orig_h, 
    //                         weight: 1
    //                     }
    //                 );
    //             }
                
    //             var my_series = [{
    //                 type: 'chord',
    //                 sort: 'ascending',
    //                 sortSub: 'descending',
    //                 showScale: false,
    //                 ribbonType: false,
    //                 radius: '68%',
    //                 minRadius: 7,
    //                 maxRadius: 20,
    //                 itemStyle: {
    //                     normal: {
    //                         chordStyle: {
    //                             color: '#999'
    //                         },
    //                         label: {
    //                             rotate: true
    //                         }
    //                     }
    //                 },
    //                 nodes: nodes_data,
    //                 links: links_data
    //             }];
    //             chord_non_ribbon.setSeries(my_series);
    //             // chord_non_ribbon.restore();
    //             clearInterval('get_domain_connect_dataInterval');
    //         }
    //     });
    // },               
    // get_domain_connect_dataInterval = setInterval(get_domain_connect_data,10000);
});
