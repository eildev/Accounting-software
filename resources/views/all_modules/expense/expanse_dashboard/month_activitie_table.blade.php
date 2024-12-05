<div class=" d-flex justify-content-between">
    <h4>Last Month Activities</h4>
    <div class="form-group primary-color-text mb-2">
        <select class="form-control primary-color-text" id="monthSalaryActivity">
            <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('m') }}">
                <p class="selected-option">Filter</p>
                <i class="fas fa-chevron-down"></i>
            </option>
            <option value="1" data-month="1">January</option>
            <option value="2" data-month="2">February</option>
            <option value="3" data-month="3">March</option>
            <option value="4" data-month="4">April</option>
            <option value="5" data-month="5">May</option>
            <option value="6" data-month="6">June</option>
            <option value="7" data-month="7">July</option>
            <option value="8" data-month="8">August</option>
            <option value="9" data-month="9">September</option>
            <option value="10" data-month="10">October</option>
            <option value="11" data-month="11">November</option>
            <option value="12" data-month="12">December</option>
        </select>
    </div>
</div>
<div class="table-container table-responsive">
    <table id="ExpansedashboardTable" class="custom-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>categories Names</th>
                <th>Transactions</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="pagination mt-3">
        <button class="prev-btn mx-2">← Previous</button>
        <div class="page-numbers d-inline"></div>
        <button class="next-btn mx-2">Next →</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load all data on page load
        fetchActivities();

        // Fetch filtered data on month change
        $('#monthSalaryActivity').change(function() {
            const selectedMonth = $(this).val();
            fetchActivities(selectedMonth);
        });

        function fetchActivities(month = '', page = 1) {
            const perPage = 5; // Items per page
            $.ajax({
                url: '/expanse/activities/filter',
                method: 'GET',
                data: {
                    month: month,
                    page: page,
                    perPage: perPage
                },
                success: function(data) {
                    console.log("Current Page:", data.current_page);
                    populateTable(data);
                    setupPagination(data);
                },
                error: function() {
                    alert('Failed to fetch activities.');
                },
            });
        }

        function populateTable(data) {
            const tbody = $('#ExpansedashboardTable tbody');
            tbody.empty();

            if (data.data.length === 0) {
                tbody.append('<tr><td colspan="5">No activities found</td></tr>');
            } else {
                const perPage = data.per_page;
                const currentPage = data.current_page;
                data.data.forEach((activity, index) => {
                    const serialNumber = (currentPage - 1) * perPage + index + 1;
                    const formattedDate = new Intl.DateTimeFormat('en-GB', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                    }).format(new Date(activity.expense_date));
                    // console.log(activity)
                    tbody.append(`
                    <tr>
                        <td>${serialNumber}</td>
                        <td>${activity.expense_cat ? activity.expense_cat.sub_ledger_name : '-'}</td>
                        <td>${activity.bank_account_id ? activity.bank?.account_name  :  activity.cash?.cash_account_name ?? '-'}</td>
                        <td>${formattedDate}</td>
                        <td>${activity.amount}</td>
                    </tr>
                `);
                })
            }
        }
        /////////////////////Pagination///////////////

        function setupPagination(data) {
            const pagination = $('.pagination');
            pagination.empty(); // Clear previous buttons

            const totalPages = data.last_page; // Total pages
            const currentPage = data.current_page; // Current page

            // Add "Previous" button
            if (currentPage > 1) {
                pagination.append(`<button class="prev-btn" data-page="${currentPage - 1}">Previous</button>`);
            }

            // Add page number buttons
            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
            <button class="page-btn mx-1  ${i === currentPage ? 'active' : ''}" data-page="${i}">
                ${i}
            </button>
        `);
            }

            // Add "Next" button
            if (currentPage < totalPages) {
                pagination.append(`<button class="next-btn" data-page="${currentPage + 1}">Next</button>`);
            }

            // Bind events to buttons
            $('.page-btn').click(function() {
                const page = $(this).data('page');
                fetchActivities($('#monthSalaryActivity').val(), page); // Fetch new page
            });

            $('.prev-btn').click(function() {
                if (currentPage > 1) {
                    fetchActivities($('#monthSalaryActivity').val(), currentPage - 1);
                }
            });

            $('.next-btn').click(function() {
                if (currentPage < totalPages) {
                    fetchActivities($('#monthSalaryActivity').val(), currentPage + 1);
                }
            });
        }

    });
</script>
