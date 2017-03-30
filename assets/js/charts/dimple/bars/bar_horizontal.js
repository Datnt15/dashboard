/* ------------------------------------------------------------------------------
 *
 *  # Dimple.js - horizontal bars
 *
 *  Demo of bar chart. Data stored in .tsv file format
 *
 *  Version: 1.0
 *  Latest update: August 1, 2015
 *
 * ---------------------------------------------------------------------------- */

$(function() {
    var myChart, x, y;
    // Construct chart
    var svg = dimple.newSvg("#dimple-bar-horizontal", "100%", 400);


    // Chart setup
    // ------------------------------

    d3.tsv("assets/demo_data/events/demo_data.tsv", function(data) {


        // Create chart
        // ------------------------------

        // Define chart
        myChart = new dimple.chart(svg, data);

        // Set bounds
        myChart.setBounds(0, 0, "100%", "100%")

        // Set margins
        myChart.setMargins(55, 5, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        x = myChart.addCategoryAxis("x", "count");
        x.addOrderRule("count");

        // Vertical
        y = myChart.addMeasureAxis("y", "ts");
        // y.addOrderRule("count");


        // Construct layout
        // ------------------------------

        // Add bars
        myChart.addSeries('Events', dimple.plot.bar);
        myChart.defaultColors = [
            //       new dimple.color("#3498db", "#2980b9", 1), // blue
            // new dimple.color("#e74c3c", "#c0392b", 1), // red

            new dimple.color("rgb(216, 122, 128)", "rgb(255, 185, 128)", 1)
            /*, // green
            new dimple.color("#9b59b6", "#8e44ad", 1), // purple
                new dimple.color("#e67e22", "#d35400", 1), // orange
                new dimple.color("#f1c40f", "#f39c12", 1), // yellow
                new dimple.color("#1abc9c", "#16a085", 1), // turquoise
                new dimple.color("#95a5a6", "#7f8c8d", 1) // gray
            */
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "11";
        y.fontSize = "12";

        // Font family
        x.fontFamily = "Roboto";
        y.fontFamily = "Roboto";

        // Draw chart
        myChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();


        // Resize chart
        // ------------------------------

        // Add a method to draw the chart on resize of the window
        $(window).on('resize', resize);
        $('.sidebar-control').on('click', resize);

        // Resize function
        function resize() {

            // Redraw chart
            myChart.draw(0, true);

            // Remove axis titles
            x.titleShape.remove();
            y.titleShape.remove();
        }

    });
    var get_bar_data = function() {
            $.ajax({
                url: $('base').attr('href') + 'index.php/home/get_bar_data',
                type: 'post',
                success: function() {
                    d3.tsv("assets/demo_data/events/demo_data.tsv", function(data) {
                        myChart.data = data;
                        // Draw
                        myChart.draw();
                        // Remove axis titles
                        x.titleShape.remove();
                        y.titleShape.remove();
                    });
                    clearInterval('get_bar_dataInterval');
                }
            });
        },
        get_bar_dataInterval = setInterval(get_bar_data, 10000);

});
