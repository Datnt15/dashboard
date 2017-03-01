/* ------------------------------------------------------------------------------
 *
 *  # Boxed page
 *
 *  Specific JS code additions for boxed layout related pages
 *
 *  Version: 1.0
 *  Latest update: May 20, 2015
 *
 * ---------------------------------------------------------------------------- */
$(function() {

    // Switchery toggles
    // ------------------------------

    var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
    switches.forEach(function(html) {
        var switchery = new Switchery(html, { color: '#4CAF50' });
    });

    // sparkline("#server-load", "area", 30, 50, "basis", 750, 2000, "rgba(255,255,255,0.5)");
    // sparkline("#server-load2", "area", 30, 50, "basis", 750, 2000, "rgba(255,255,255,0.5)");

    // Chart setup
    // function sparkline(element, chartType, qty, height, interpolation, duration, interval, color) {


    //     // Basic setup
    //     // ------------------------------

    //     // Define main variables
    //     var d3Container = d3.select(element),
    //         margin = {top: 0, right: 0, bottom: 0, left: 0},
    //         width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
    //         height = height - margin.top - margin.bottom;


    //     // Generate random data (for demo only)
    //     var data = [];
    //     for (var i=0; i < qty; i++) {
    //         data.push(Math.floor(Math.random() * qty) + 5)
    //     }



    //     // Construct scales
    //     // ------------------------------

    //     // Horizontal
    //     var x = d3.scale.linear().range([0, width]);

    //     // Vertical
    //     var y = d3.scale.linear().range([height - 5, 5]);



    //     // Set input domains
    //     // ------------------------------

    //     // Horizontal
    //     x.domain([1, qty - 3])

    //     // Vertical
    //     y.domain([0, qty])



    //     // Construct chart layout
    //     // ------------------------------

    //     // Line
    //     var line = d3.svg.line()
    //         .interpolate(interpolation)
    //         .x(function(d, i) { return x(i); })
    //         .y(function(d, i) { return y(d); });

    //     // Area
    //     var area = d3.svg.area()
    //         .interpolate(interpolation)
    //         .x(function(d,i) { 
    //             return x(i); 
    //         })
    //         .y0(height)
    //         .y1(function(d) { 
    //             return y(d); 
    //         });



    //     // Create SVG
    //     // ------------------------------

    //     // Container
    //     var container = d3Container.append('svg');

    //     // SVG element
    //     var svg = container
    //         .attr('width', width + margin.left + margin.right)
    //         .attr('height', height + margin.top + margin.bottom)
    //         .append("g")
    //             .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    //     // Add mask for animation
    //     // ------------------------------

    //     // Add clip path
    //     var clip = svg.append("defs")
    //         .append("clipPath")
    //         .attr('id', function(d, i) { return "load-clip-" + element.substring(1) })

    //     // Add clip shape
    //     var clips = clip.append("rect")
    //         .attr('class', 'load-clip')
    //         .attr("width", 0)
    //         .attr("height", height);

    //     // Animate mask
    //     clips
    //         .transition()
    //             .duration(1000)
    //             .ease('linear')
    //             .attr("width", width);



    //     //
    //     // Append chart elements
    //     //

    //     // Main path
    //     var path = svg.append("g")
    //         .attr("clip-path", function(d, i) { return "url(#load-clip-" + element.substring(1) + ")"})
    //         .append("path")
    //             .datum(data)
    //             .attr("transform", "translate(" + x(0) + ",0)");

    //     // Add path based on chart type
    //     if(chartType == "area") {
    //         path.attr("d", area).attr('class', 'd3-area').style("fill", color); // area
    //     }
    //     else {
    //         path.attr("d", line).attr("class", "d3-line d3-line-medium").style('stroke', color); // line
    //     }

    //     // Animate path
    //     path
    //         .style('opacity', 0)
    //         .transition()
    //             .duration(750)
    //             .style('opacity', 1);



    //     // Set update interval. For demo only
    //     // ------------------------------

    //     setInterval(function() {

    //         // push a new data point onto the back
    //         data.push(Math.floor(Math.random() * qty) + 5);

    //         // pop the old data point off the front
    //         data.shift();

    //         update();

    //     }, interval);



    //     // Update random data. For demo only
    //     // ------------------------------

    //     function update() {

    //         // Redraw the path and slide it to the left
    //         path
    //             .attr("transform", null)
    //             .transition()
    //                 .duration(duration)
    //                 .ease("linear")
    //                 .attr("transform", "translate(" + x(0) + ",0)");

    //         // Update path type
    //         if(chartType == "area") {
    //             path.attr("d", area).attr('class', 'd3-area').style("fill", color)
    //         }
    //         else {
    //             path.attr("d", line).attr("class", "d3-line d3-line-medium").style('stroke', color);
    //         }
    //     }



    //     // Resize chart
    //     // ------------------------------

    //     // Call function on window resize
    //     $(window).on('resize', resizeSparklines);

    //     // Call function on sidebar width change
    //     $(document).on('click', '.sidebar-control', resizeSparklines);

    //     // Resize function
    //     // 
    //     // Since D3 doesn't support SVG resize by default,
    //     // we need to manually specify parts of the graph that need to 
    //     // be updated on window resize
    //     function resizeSparklines() {

    //         // Layout variables
    //         width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


    //         // Layout
    //         // -------------------------

    //         // Main svg width
    //         container.attr("width", width + margin.left + margin.right);

    //         // Width of appended group
    //         svg.attr("width", width + margin.left + margin.right);

    //         // Horizontal range
    //         x.range([0, width]);


    //         // Chart elements
    //         // -------------------------

    //         // Clip mask
    //         clips.attr("width", width);

    //         // Line
    //         svg.select(".d3-line").attr("d", line);

    //         // Area
    //         svg.select(".d3-area").attr("d", area);
    //     }
    // }



    // Marketing campaigns donut chart
    // ------------------------------













    // Bar charts with random data
    // ------------------------------

    // Initialize charts
    // generateBarChart("#hours-available-bars", 24, 40, true, "elastic", 1200, 50, "#EC407A", "hours");
    // generateBarChart("#goal-bars", 24, 40, true, "elastic", 1200, 50, "#5C6BC0", "goal");
    // generateBarChart("#members-online", 24, 50, true, "elastic", 1200, 50, "rgba(255,255,255,0.5)", "members");

    // Chart setup
    function generateBarChart(element, barQty, height, animate, easing, duration, delay, color, tooltip) {


        // Basic setup
        // ------------------------------

        // Add data set
        var bardata = [];
        for (var i = 0; i < barQty; i++) {
            bardata.push(Math.round(Math.random() * 10) + 10)
        }

        // Main variables
        var d3Container = d3.select(element),
            width = d3Container.node().getBoundingClientRect().width;



        // Construct scales
        // ------------------------------

        // Horizontal
        var x = d3.scale.ordinal()
            .rangeBands([0, width], 0.3)

        // Vertical
        var y = d3.scale.linear()
            .range([0, height]);



        // Set input domains
        // ------------------------------

        // Horizontal
        x.domain(d3.range(0, bardata.length))

        // Vertical
        y.domain([0, d3.max(bardata)])



        // Create chart
        // ------------------------------

        // Add svg element
        var container = d3Container.append('svg');

        // Add SVG group
        var svg = container
            .attr('width', width)
            .attr('height', height)
            .append('g');



        //
        // Append chart elements
        //

        // Bars
        var bars = svg.selectAll('rect')
            .data(bardata)
            .enter()
            .append('rect')
            .attr('class', 'd3-random-bars')
            .attr('width', x.rangeBand())
            .attr('x', function(d, i) {
                return x(i);
            })
            .style('fill', color);



        // Tooltip
        // ------------------------------

        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0]);

        // Show and hide
        if (tooltip == "hours" || tooltip == "goal" || tooltip == "members") {
            bars.call(tip)
                .on('mouseover', tip.show)
                .on('mouseout', tip.hide);
        }

        // Daily meetings tooltip content
        if (tooltip == "hours") {
            tip.html(function(d, i) {
                return "<div class='text-center'>" +
                    "<h6 class='no-margin'>" + d + "</h6>" +
                    "<span class='text-size-small'>meetings</span>" +
                    "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }

        // Statements tooltip content
        if (tooltip == "goal") {
            tip.html(function(d, i) {
                return "<div class='text-center'>" +
                    "<h6 class='no-margin'>" + d + "</h6>" +
                    "<span class='text-size-small'>statements</span>" +
                    "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }

        // Online members tooltip content
        if (tooltip == "members") {
            tip.html(function(d, i) {
                return "<div class='text-center'>" +
                    "<h6 class='no-margin'>" + d + "0" + "</h6>" +
                    "<span class='text-size-small'>members</span>" +
                    "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }



        // Bar loading animation
        // ------------------------------

        // Choose between animated or static
        if (animate) {
            withAnimation();
        } else {
            withoutAnimation();
        }

        // Animate on load
        function withAnimation() {
            bars
                .attr('height', 0)
                .attr('y', height)
                .transition()
                .attr('height', function(d) {
                    return y(d);
                })
                .attr('y', function(d) {
                    return height - y(d);
                })
                .delay(function(d, i) {
                    return i * delay;
                })
                .duration(duration)
                .ease(easing);
        }

        // Load without animateion
        function withoutAnimation() {
            bars
                .attr('height', function(d) {
                    return y(d);
                })
                .attr('y', function(d) {
                    return height - y(d);
                })
        }



        // Resize chart
        // ------------------------------

        // Call function on window resize
        $(window).on('resize', barsResize);

        // Call function on sidebar width change
        $(document).on('click', '.sidebar-control', barsResize);

        // Resize function
        // 
        // Since D3 doesn't support SVG resize by default,
        // we need to manually specify parts of the graph that need to 
        // be updated on window resize
        function barsResize() {

            // Layout variables
            width = d3Container.node().getBoundingClientRect().width;


            // Layout
            // -------------------------

            // Main svg width
            container.attr("width", width);

            // Width of appended group
            svg.attr("width", width);

            // Horizontal range
            x.rangeBands([0, width], 0.3);


            // Chart elements
            // -------------------------

            // Bars
            svg.selectAll('.d3-random-bars')
                .attr('width', x.rangeBand())
                .attr('x', function(d, i) {
                    return x(i);
                });
        }
    }




    // Animated progress chart
    // ------------------------------

    // Initialize charts
    // progressCounter('#hours-available-progress', 38, 2, "#F06292", 0.68, "icon-watch text-pink-400", 'Increment', '64% average')
    // progressCounter('#goal-progress', 38, 2, "#5C6BC0", 0.82, "icon-trophy3 text-indigo-400", 'Productivity goal', '87% average')

    // Chart setup
    function progressCounter(element, radius, border, color, end, iconClass, textTitle, textAverage) {


        // Basic setup
        // ------------------------------

        // Main variables
        var d3Container = d3.select(element),
            startPercent = 0,
            iconSize = 32,
            endPercent = end,
            twoPi = Math.PI * 2,
            formatPercent = d3.format('.0%'),
            boxSize = radius * 2;

        // Values count
        var count = Math.abs((endPercent - startPercent) / 0.01);

        // Values step
        var step = endPercent < startPercent ? -0.01 : 0.01;



        // Create chart
        // ------------------------------

        // Add SVG element
        var container = d3Container.append('svg');

        // Add SVG group
        var svg = container
            .attr('width', boxSize)
            .attr('height', boxSize)
            .append('g')
            .attr('transform', 'translate(' + (boxSize / 2) + ',' + (boxSize / 2) + ')');



        // Construct chart layout
        // ------------------------------

        // Arc
        var arc = d3.svg.arc()
            .startAngle(0)
            .innerRadius(radius)
            .outerRadius(radius - border);



        //
        // Append chart elements
        //

        // Paths
        // ------------------------------

        // Background path
        svg.append('path')
            .attr('class', 'd3-progress-background')
            .attr('d', arc.endAngle(twoPi))
            .style('fill', '#eee');

        // Foreground path
        var foreground = svg.append('path')
            .attr('class', 'd3-progress-foreground')
            .attr('filter', 'url(#blur)')
            .style('fill', color)
            .style('stroke', color);

        // Front path
        var front = svg.append('path')
            .attr('class', 'd3-progress-front')
            .style('fill', color)
            .style('fill-opacity', 1);



        // Text
        // ------------------------------

        // Percentage text value
        var numberText = d3.select(element)
            .append('h2')
            .attr('class', 'mt-15 mb-5')

        // Icon
        d3.select(element)
            .append("i")
            .attr("class", iconClass + " counter-icon")
            .attr('style', 'top: ' + ((boxSize - iconSize) / 2) + 'px');

        // Title
        d3.select(element)
            .append('div')
            .text(textTitle);

        // Subtitle
        d3.select(element)
            .append('div')
            .attr('class', 'text-size-small text-muted')
            .text(textAverage);



        // Animation
        // ------------------------------

        // Animate path
        function updateProgress(progress) {
            foreground.attr('d', arc.endAngle(twoPi * progress));
            front.attr('d', arc.endAngle(twoPi * progress));
            numberText.text(formatPercent(progress));
        }

        // Animate text
        var progress = startPercent;
        (function loops() {
            updateProgress(progress);
            if (count > 0) {
                count--;
                progress += step;
                setTimeout(loops, 10);
            }
        })();
    }




    // Other codes
    // ------------------------------

    // Grab first letter and insert to the icon
    $(".table tr").each(function(i) {

        // Title
        var $title = $(this).find('.letter-icon-title'),
            letter = $title.eq(0).text().charAt(0).toUpperCase();

        // Icon
        var $icon = $(this).find('.letter-icon');
        $icon.eq(0).text(letter);
    });

});
