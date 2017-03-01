/* ------------------------------------------------------------------------------
 *
 *  # Advanced datatables
 *
 *  Specific JS code additions for datatable_advanced.html page
 *
 *  Version: 1.0
 *  Latest update: Aug 1, 2015
 *
 * ---------------------------------------------------------------------------- */

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: '100px',
            targets: [5]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });



    // Columns rendering
    $('.datatable-columns').dataTable({
        "order": [
            [2, "desc"]
        ],
        pageLength: 5
    });



    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder', 'Type to filter...');

    var get_table_data = function() {
            $.ajax({
                url: $('base').attr('href') + 'index.php/home/get_table_data',
                type: 'get',
                success: function(data) {
                    $('#my-table').html(data);
                    $('#my-table .datatable-columns').DataTable({
                        "order": [
                            [2, "desc"]
                        ],
                        pageLength: 5
                    });

                    clearInterval('get_table_dataInterval');
                }
            });
        },
        get_table_dataInterval = setInterval(get_table_data, 100000);

});
