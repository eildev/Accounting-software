<div class=" d-flex justify-content-between">
    <h3>Salary Sheet</h3>
    <div class="form-group primary-color-text">
        <select class="form-control primary-color-text" id="salaryMonthSelect">
            <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('m') }}">
                <p class="selected-option">Month</p>
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
    <table id="dashboardTable" class="custom-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Job Title</th>
                <th>Net Salary</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be dynamically inserted here -->
        </tbody>
    </table>
    <div class="pagination">
        <button class="prev-btn mx-2">← Previous</button>
        <div class="page-numbers"></div>
        <button class="next-btn mx-2">Next →</button>
    </div>
</div>
<script>
 $(document).ready(function () {
    const currentMonth = new Date().getMonth() + 1; // Months are 0-based in JavaScript
    const currentYear = new Date().getFullYear(); // Get current year
    let currentPage = 1; // Set the initial page

    // Function to fetch salaries with pagination
    function fetchSalaries(month, year, page = 1) {
        $.ajax({
            url: '/get-salaries-filter-month',
            type: 'GET',
            data: {
                month: month,
                year: year,
                page: page,
                perPage: 5 // Set how many results per page
            },
            success: function (response) {
                const netSalarys = response.netSalarys.data; // The paginated data
                let rows = '';

                if (netSalarys.length > 0) {
                    netSalarys.forEach((salary, index) => {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${salary.employee?.full_name || ''}</td>
                                <td>${salary.employee?.designation || '-'}</td>
                                <td>${salary.total_net_salary || '-'}</td>
                                <td>${new Date(salary.pay_period_date).toLocaleDateString('en-US', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                })}</td>
                                <td>
                                    <span class="badge ${
                                        salary.status === 'pending' ? 'delayed' :
                                        salary.status === 'approved' ? 'bg-info' :
                                        salary.status === 'paid' ? 'bg-success' :
                                        'bg-delayed'
                                    }">${salary.status}</span>
                                </td>
                            </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="6" class="text-center">No data available</td></tr>`;
                }

                $('#dashboardTable tbody').html(rows);
                setupPagination(response); // Set up pagination based on the response
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Set up pagination controls
    function setupPagination(data) {
        const pagination = $('.pagination');
        pagination.empty(); // Clear previous pagination buttons

        const totalPages = data.last_page; // Total pages
        const currentPage = data.current_page; // Current page

        // Add "Previous" button
        if (currentPage > 1) {
            pagination.append(`<button class="prev-btn" data-page="${currentPage - 1}">Previous</button>`);
        }

        // Add page number buttons
        for (let i = 1; i <= totalPages; i++) {
            pagination.append(`
                <button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">
                    ${i}
                </button>
            `);
        }

        // Add "Next" button
        if (currentPage < totalPages) {
            pagination.append(`<button class="next-btn" data-page="${currentPage + 1}">Next</button>`);
        }

        // Bind events to pagination buttons
        $('.page-btn').click(function () {
            const page = $(this).data('page');
            fetchSalaries(currentMonth, currentYear, page); // Fetch data for the selected page
        });

        $('.prev-btn').click(function () {
            if (currentPage > 1) {
                fetchSalaries(currentMonth, currentYear, currentPage - 1);
            }
        });

        $('.next-btn').click(function () {
            if (currentPage < totalPages) {
                fetchSalaries(currentMonth, currentYear, currentPage + 1);
            }
        });
    }

    // Load the current month's salaries on page load
    fetchSalaries(currentMonth, currentYear);

    // Fetch salaries when month is changed
    $('#salaryMonthSelect').on('change', function () {
        const selectedMonth = $(this).val();
        fetchSalaries(selectedMonth, currentYear); // Fetch data for the selected month
    });
});

</script>


