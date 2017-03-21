/* ------------------------------------------------------------------------------
 *
 *  # Vector maps
 *
 *  Specific JS code additions for maps_vector.html page
 *
 *  Version: 1.0
 *  Latest update: Aug 1, 2015
 *
 * ---------------------------------------------------------------------------- */

$(function() {

    // Custom markers
    $('.map-world-markers').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'rgb(4, 58, 87)',
        scaleColors: ['#C8EEFF', '#0071A4'],
        normalizeFunction: 'polynomial',
        regionStyle: {
            initial: {
                fill: 'rgb(4, 17, 37)'
            }
        },
        hoverOpacity: 0.7,
        hoverColor: false,
        zoomOnScroll: false,
        markerStyle: {
            initial: {
                r: 5,
                'fill': 'red',
                'fill-opacity': 0.9,
                'stroke': '#fff',
                'stroke-width': 1.5,
                'style': '-webkit-animation: fade 2s infinite; -moz-animation: fade 2s infinite; -o-animation: fade 2s infinite;',
                'stroke-opacity': 0.9
            },
            hover: {
                'stroke': '#fff',
                'fill-opacity': 1,
                'stroke-width': 1.5
            }
        },
        focusOn: {
            x: 0.5,
            y: 0.5,
            scale: 1
        },
        markers: data_marker
    });
    var last;

    var table_data = data_map_table.reduce(function(prev, curr) {
        if (last) {
            sum += parseInt(curr[2]);
            if (last[0] === curr[0]) {
                last[2] += parseInt(curr[2]);
                return prev;
            }
        }
        last = curr;
        prev.push(curr);
        return prev;
    }, []);

    Array.prototype.sum = function(index) {
        var total = 0;
        for (var i = 0, _len = this.length; i < _len; i++) {
            total += parseInt(this[i][index]);
        }
        return total;
    }

    table_data.sort(function(a, b) {
        return parseFloat(b[2]) - parseFloat(a[2]);
    });

    var sum = table_data.sum(2),
        tbody = "";
    for (var i = 0; i < table_data.length; i++) {
        tbody += "<tr><td><img src='" + table_data[i][1] + "'></td>" +
            "<td>" + table_data[i][0] + "</td>" +
            "<td><span class=\"badge bg-info-400\">" + table_data[i][2] + "</span></td>" +
            "<td><span class=\"badge bg-info-400\">" + (parseFloat(table_data[i][2]) / sum * 100).toFixed(2) + "%</span></td></tr>";
    }

    $("#top-attack-country > tbody").append(tbody);



});
