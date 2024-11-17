<!DOCTYPE html>
<html lang="en">

<head>
    @include('body.css')
</head>

<body>
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->
        @include('body.sidebar')
        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('body.navbar')
            <!-- partial -->

            <div class="page-content">
                @yield('admin')
            </div>

            <!-- partial:partials/_footer.html -->
            @include('body.footer')
            <!-- partial -->

        </div>
    </div>


    <!-- Modal Payment -->
    <div class="modal fade" id="globalPaymentModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentForm" class="addPaymentForm row" method="POST">
                        <input type="hidden" name="data_id" id="data_id" value="">
                        <input type="hidden" name="payment_balance" id="payment_balance" value="">
                        <input type="hidden" name="purpose" id="purpose" value="">
                        <input type="hidden" name="transaction_type" id="transaction_type" value="">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Installment Amount : <span id="due-amount"></span>
                                ৳</label>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Account Type<span
                                    class="text-danger">*</span></label>
                            <select class="form-control account_type" name="account_type" onclick="errorRemove(this);"
                                onchange="checkPaymentAccount(this);">
                                <option value="">Select Account Type</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                            </select>
                            <span class="text-danger account_type_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Payment Account<span
                                    class="text-danger">*</span></label>
                            <select class="form-control payment_account_id" name="payment_account_id"
                                onchange="errorRemove(this);">
                                <option value="">Select Payment Account</option>
                            </select>
                            <span class="text-danger payment_account_id_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-primary" id="save_global_payment">Payment</a>
                </div>
            </div>
        </div>
    </div>



    @include('body.js')
</body>
<script>
    // global check payment func 
    function checkPaymentAccount(element) {
        const paymentType = $(element).val(); // 'element' is passed in from the onclick event
        const paymentAccounts = $('.payment_account_id');
        $.ajax({
            url: '/check-account-type',
            method: 'GET',
            data: {
                payment_type: paymentType
            },
            success: function(res) {
                const accounts = res.data;
                // console.log(accounts);
                if (accounts.length > 0) {
                    $('.payment_account_id').html(
                        `<option selected disabled>Select Account</option>`
                    ); // Clear and set default option
                    $.each(accounts, function(index, account) {
                        // console.log(account);
                        $('.payment_account_id').append(
                            `<option value="${account.id}">${account.bank_name ?? account.cash_account_name ?? ""}</option>`
                        );
                    });

                } else {
                    $('.payment_account_id').html(
                        `<option selected disabled>No Account Found</option>`
                    ); // Clear and set default option
                }
            }
        });

    }


    const saveGlobalPayment = document.getElementById('save_global_payment');
    saveGlobalPayment.addEventListener('click', function(e) {
        // console.log('Working on payment')
        e.preventDefault();

        let formData = new FormData($('.addPaymentForm')[0]);
        let paymentBalance = parseFloat($('#payment_balance').val());

        // CSRF Token setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // // AJAX request
        $.ajax({
            url: '/transaction/store/with-ledger',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                // console.log(res);
                if (res.status == 200) {
                    // Hide the correct modal
                    $('#duePayment').modal('hide');
                    // Reset the form
                    $('.addPaymentForm')[0].reset();
                    toastr.success(res.message);
                    window.location.reload();
                } else if (res.status == 400) {
                    toastr.warning(res.message);
                } else {
                    // console.log(res.error);
                    if (res.message) {
                        toastr.error(res.error);
                    }
                    if (res.error.data_id) {
                        toastr.error(res.error.data_id);
                    }
                    if (res.error.account_type) {
                        showError('.account_type', res.error.account_type);
                    }
                    if (res.error.account_type) {
                        showError('.account_type', res.error.account_type);
                    }
                    if (res.error.payment_account_id) {
                        showError('.payment_account_id', res.error.payment_account_id);
                    }
                    if (res.error.repayment_date) {
                        showError('.repayment_date', res.error.repayment_date);
                    }
                    if (res.error.payment_balance) {
                        toastr.error(res.error.payment_balance);
                    }
                }
            },
            error: function(err) {
                toastr.error('An error occurred, Something Went Wrong.');
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        modalShowHide('globalPaymentModal'); // Moved inside DOMContentLoaded event
    });



    document.addEventListener('DOMContentLoaded', function() {
        const flexSwitchCheckDefault = document.querySelector('.flexSwitchCheckDefault');
        const form = document.getElementById('darkModeForm');
        if (flexSwitchCheckDefault && form) {
            flexSwitchCheckDefault.addEventListener('change', function() {
                form.submit();
            });
        }

        // nav links active
        const links = document.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                // Handle collapse behavior
                const parentMenu = this.closest('.collapse');
                if (parentMenu) {
                    parentMenu.classList.add('show');
                    parentMenu.previousElementSibling.setAttribute('aria-expanded', 'true');
                    parentMenu.previousElementSibling.classList.remove('collapsed');
                }
            });

            // Ensure parent menus stay open if a child link is active
            if (link.classList.contains('active')) {
                const parentMenu = link.closest('.collapse');
                if (parentMenu) {
                    parentMenu.classList.add('show');
                    parentMenu.previousElementSibling.setAttribute('aria-expanded', 'true');
                    parentMenu.previousElementSibling.classList.remove('collapsed');
                }
            }
        });
    });
    $(function() {
        'use strict'

        if ($(".compose-multiple-select").length) {
            $(".compose-multiple-select").select2();
        }

        /*easymde editor*/
        if ($("#easyMdeEditor").length) {
            var easymde = new EasyMDE({
                element: $("#easyMdeEditor")[0]
            });
        }

    });


    const global_search = document.querySelector("#global_search");
    const search_result = document.querySelector(".search_result");
    // console.log(global_search);
    global_search.addEventListener('keyup', function() {
        // console.log(global_search.value);
        if (global_search.value != '') {
            $.ajax({
                url: '/search/' + global_search.value,
                type: 'GET',
                success: function(res) {
                    // console.log(res);
                    let findData = '';
                    search_result.style.display = 'block';
                    if (res.products.length > 0) {
                        $.each(res.products, function(key, value) {
                            findData += `<tr>
                                    <td>${value.name}</td>
                                    <td>${value.stock}</td>
                                    <td>${value.price}</td>
                                </tr>`
                        });

                        $('.findData').html(findData);
                    } else {
                        $('.table_header').hide();
                        findData += `<tr>
                                    <td colspan = "3" class = "text-center">Data not Found</td>
                                </tr>`
                        $('.findData').html(findData);
                    }
                }
            });
        } else {
            search_result.style.display = 'none';
        }
    })

    global_search.addEventListener('click', function() {
        // console.log(global_search.value);
        if (global_search.value != '') {
            $.ajax({
                url: '/search/' + global_search.value,
                type: 'GET',
                success: function(res) {
                    // console.log(res);
                    let findData = '';
                    search_result.style.display = 'block';
                    if (res.products.length > 0) {
                        $.each(res.products, function(key, value) {
                            findData += `<tr>
                                            <td>${value.name}</td>
                                            <td>${value.stock}</td>
                                            <td>${value.price}</td>
                                        </tr>`
                        });

                        $('.findData').html(findData);
                    } else {
                        $('.table_header').hide();
                        findData += `<tr>
                                        <td colspan = "3" class = "text-center">Data not Found</td>
                                    </tr>`
                        $('.findData').html(findData);
                    }
                }
            });
        } else {
            search_result.style.display = 'none';
        }
    })

    global_search.addEventListener('blur', function() {
        search_result.style.display = 'none';
    });


    ///////////////////////// Modal show and close function /////////////////// 
    // function modalShowHide(element) {
    //     var modalName = new bootstrap.Modal(document.getElementById(`${element}`), {
    //         backdrop: 'static', // Prevent closing by clicking outside
    //         keyboard: false // Prevent closing with Escape key
    //     });

    //     console.log(element);
    //     console.log(modalName);

    //     // Trigger modal open when the button is clicked
    //     document.querySelector(`.btn[data-bs-target="#${element}"]`).addEventListener('click',
    //         function() {
    //             modalName.show();
    //         });

    //     // Custom close functionality for specific buttons
    //     document.querySelector('.modal_close').addEventListener('click', function() {
    //         modalName.hide();
    //     });
    //     document.querySelector('.btn-close').addEventListener('click', function() {
    //         modalName.hide();
    //     });
    // }
    function modalShowHide(element) {
        var modalElement = document.getElementById(`${element}`);
        if (!modalElement) {
            console.error(`Modal with ID "${element}" not found.`);
            return; // Stop execution if modal is not found
        }

        var modalName = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });

        // Check for existence of button and add event listeners conditionally
        var modalButton = document.querySelector(`.btn[data-bs-target="#${element}"]`);
        if (modalButton) {
            modalButton.addEventListener('click', function() {
                modalName.show();
            });
        } else {
            console.warn(`Button with data-bs-target="#${element}" not found.`);
        }

        // Attach close button event listeners only if the elements exist
        var closeModalButton = document.querySelector('.modal_close');
        if (closeModalButton) {
            closeModalButton.addEventListener('click', function() {
                modalName.hide();
            });
        }

        var btnClose = document.querySelector('.btn-close');
        if (btnClose) {
            btnClose.addEventListener('click', function() {
                modalName.hide();
            });
        }
    }




    ///////////////////////// Data Table Function function /////////////////// 
    function dynamicDataTableFunc(table) {
        $(`#${table}`).DataTable({
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        header: true,
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        return '{{ $header ?? '' }}\n {{ $phone ?? '+880.....' }}\n {{ $email ?? '' }}\n{{ $address ?? '' }}\n\n' +
                            xlsx + '\n\n';
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        header: true,
                        columns: ':visible'
                    },
                    customize: function(doc) {
                        doc.content.unshift({
                            text: '{{ $header ?? '' }}\n {{ $phone ?? '+880.....' }}\n {{ $email ?? '' }}\n{{ $address ?? '' }}',
                            fontSize: 14,
                            alignment: 'center',
                            margin: [0, 0, 0, 12]
                        });
                        doc.content.push({
                            text: 'Thank you for using our service!',
                            fontSize: 14,
                            alignment: 'center',
                            margin: [0, 12, 0, 0]
                        });
                        return doc;
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        header: true,
                        columns: ':visible'
                    },
                    customize: function(win) {
                        $(win.document.body).prepend(
                            '<h4>{{ $header }}</br>{{ $phone ?? '+880....' }}</br>Email:{{ $email }}</br>Address:{{ $address }}</h4>'
                        );
                        $(win.document.body).find('h1')
                            .hide(); // Hide the title element
                    }
                }
            ]
        });
    }
</script>

</html>
