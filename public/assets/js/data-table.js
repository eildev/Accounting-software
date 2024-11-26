// npm package: datatables.net-bs5
// github link: https://github.com/DataTables/Dist-DataTables-Bootstrap5

$(function() {
  'use strict';

  $(function() {
    $('#dataTableExample').DataTable({
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      }
    });
    $('#dataTableExample').each(function() {

      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });

});
/////////////////////////id="dataTableExample1"///////

$(function() {
  'use strict';
  $(function() {
    $('#dataTableExample1').DataTable({
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      }
    });
    $('#dataTableExample1').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });

});
//////////////////id="dataTableExample2"/////////
$(function() {
    'use strict';
    $(function() {
      $('#dataTableExample2').DataTable({
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
        "aLengthMenu": [
          [10, 30, 50, -1],
          [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
          search: ""
        }
      });
      $('#dataTableExample2').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
      });
    });

  });
//////////////////id="dataTableExample4"/////////
  $(function() {
    'use strict';
    $(function() {
      $('#dataTableExample4').DataTable({
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
        "aLengthMenu": [
          [10, 30, 50, -1],
          [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
          search: ""
        }
      });
      $('#dataTableExample4').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
      });
    });

  });
  $(function () {
    'use strict';

    // Initialize DataTable with custom settings
    var table = $('#dashboardTable').DataTable({
        columnDefs: [
            {
                "defaultContent": "-",
                "targets": "_all",
            },
        ],
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"],
        ],
        "iDisplayLength": 5, // Set default number of items per page
        "paging": false,      // Disable DataTable default pagination
        "searching": false,   // Disable the search box (optional)
        "info": false
    });

    // Custom Pagination Logic
    let currentPage = 1;
    let rowsPerPage = table.page.len(); // Use the display length defined in DataTable
    let totalRows = table.data().length;
    let totalPages = Math.ceil(totalRows / rowsPerPage); // Calculate total pages based on data length

    // Generate Page Buttons Dynamically
    function generatePageButtons() {
        let pageNumbers = $('.page-numbers');
        pageNumbers.empty(); // Clear existing page numbers
        for (let i = 1; i <= totalPages; i++) {
            pageNumbers.append('<button class="page-btn">' + i + '</button>');
        }

        // Bind click events to page buttons
        $('.page-btn').click(function () {
            currentPage = $(this).index() + 1; // Set the current page
            updatePagination();
        });
    }

    // Update Pagination UI
    function updatePagination() {
        // Disable the Previous button on the first page
        if (currentPage === 1) {
            $('.prev-btn').attr('disabled', true);
        } else {
            $('.prev-btn').removeAttr('disabled');
        }

        // Disable the Next button on the last page
        if (currentPage === totalPages) {
            $('.next-btn').attr('disabled', true);
        } else {
            $('.next-btn').removeAttr('disabled');
        }

        // Update the active page button
        $('.page-btn').removeClass('active');
        $('.page-btn').eq(currentPage - 1).addClass('active');

        // Show rows for the current page and hide others
        let startIndex = (currentPage - 1) * rowsPerPage;
        let endIndex = startIndex + rowsPerPage;

        table.rows().every(function (index) {
            let row = $(this.node());
            if (index >= startIndex && index < endIndex) {
                row.show();
            } else {
                row.hide();
            }
        });
    }

    // Click event for previous button
    $('.prev-btn').click(function () {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    });

    // Click event for next button
    $('.next-btn').click(function () {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    });

    // Initialize the pagination
    generatePageButtons();
    updatePagination(); // Ensure the first 10 rows are displayed on page load
});



