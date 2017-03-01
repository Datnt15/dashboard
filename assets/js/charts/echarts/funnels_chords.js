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
            chord_non_ribbon = ec.init(document.getElementById('chord_non_ribbon'), limitless);

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

                // Add legend
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data: legend_data
                },

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
            
            chord_non_ribbon.setOption(chord_non_ribbon_options);
            
            // Resize charts
            // ------------------------------

            window.onresize = function () {
                setTimeout(function (){
                    
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
