@extends('master')
@section('title', '| Product Sale')
@section('admin')

    <style>
        .table thead tr th,
        .table tbody tr td,
        .table tbody tr td input {
            font-size: 10px !important;
        }

        .table> :not(caption)>*>* {
            padding: 5px 5px !important;
        }

        input,
        select,
        .grid-margin p {
            font-size: 12px !important;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card mb-3">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="row">
                        @if ($barcode == 1)
                            <div class="mb-2 col-md-6">
                                <label for="ageSelect" class="form-label">Barcode</label>

                                <div class="input-group">
                                    <div class="input-group-text" id="btnGroupAddon"><i class="fa-solid fa-barcode"></i>
                                    </div>
                                    <input type="text" class="form-control barcode_input" placeholder="Barcode"
                                        aria-label="Input group example" aria-describedby="btnGroupAddon">
                                </div>
                            </div>
                        @endif
                        <div class="mb-2 @if ($barcode == 1) col-md-6 @else col-md-2 @endif">
                            <label for="date" class="form-label">Date</label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="date"
                                    class="form-control bg-transparent border-primary purchase_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger purchase_date_error"></span>
                        </div>
                        <div class="mb-1 @if ($barcode == 1) col-md-6 @else col-md-5 @endif">
                            <label class="form-label">Product</label>
                            <div class="row mx-1">
                                <div class="col-md-12 p-0">
                                    <select class="js-example-basic-single form-select product_select view_product"
                                        data-width="100%">

                                    </select>
                                    <span class="text-danger product_select_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 @if ($barcode == 1) col-md-6 @else col-md-5 @endif">
                            <label for="password" class="form-label">Customer</label>
                            <div class="row mx-1">
                                <div class="col-md-9 p-0">
                                    <select class="js-example-basic-single form-select select-customer"
                                        data-width="100%"></select>
                                    <span class="text-danger select-customer_error"></span>
                                </div>
                                <div class="col-md-3 p-0">
                                    <button class="btn btn-sm btn-primary ms-2 via_sell_btn w-100 h-100"
                                        data-bs-toggle="modal" data-bs-target="#customerModal">Add</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" class="generate_invoice">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- table  --}}
    <div class="row">
        <div class="col-md-7 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="mb-3">
                        <h6 class="card-title">Items</h6>
                    </div>

                    <div id="" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>Sub Total</th>
                                    <th>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="row align-items-center mb-2">
                        <div class="col-sm-4">
                            <p>Product Total :</p>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control total border-0 " name="total" readonly
                                value="0.00" />
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-sm-4">
                            <p> Discount :</p>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control handsOnDiscount" name="" value="" />
                        </div>
                    </div>
                    <div class="row align-items-center mb-2 previous_due_field">
                        <div class="col-sm-4">
                            <p> Grand Total:</p>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control grand_total border-0 " name="grand_total" readonly
                                value="0.00" />
                        </div>
                    </div>

                    <div class="my-3">
                        <button class="btn btn-primary payment_btn"><i class="fa-solid fa-money-check-dollar"></i>
                            Make Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #printFrame {
            display: none;
            /* Hide the iframe */
        }
    </style>
    <iframe id="printFrame" src="" width="0" height="0"></iframe>
    <!-- customer Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Customer Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="customerForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control customer_name" maxlength="255" name="name"
                                type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger customer_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Phone Nnumber <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control phone" maxlength="39" name="phone"
                                type="tel" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger phone_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Email</label>
                            <input id="defaultconfig" class="form-control email" maxlength="39" name="email"
                                type="email">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Address</label>
                            <input id="defaultconfig" class="form-control address" maxlength="39" name="address"
                                type="text">
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Previous Due</label>
                                <input type="number" class="form-control" name="wallet_balance" placeholder="0.00">
                            </div>
                        </div><!-- Col -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_new_customer">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // error remove
        function errorRemove(element) {
            tag = element.tagName.toLowerCase();
            if (element.value != '') {
                // console.log('ok');
                if (tag == 'select') {
                    $(element).closest('.mb-3').find('.text-danger').hide();
                } else {
                    $(element).siblings('span').hide();
                    $(element).css('border-color', 'green');
                }
            }
        }

        // define warranty period
        $(document).on('click', '#warranty_status', function() {
            if ($(this).is(':checked')) {
                $(this).closest('div').next('.Warranty_duration').show();
            } else {
                $(this).closest('div').next('.Warranty_duration').hide();
            }
        });



        //  jquery redy function
        $(document).ready(function() {
            // Barcode Focused
            $('.barcode_input').focus();

            // showError Function
            function showError(name, message) {
                $(name).css('border-color', 'red');
                $(name).focus();
                $(`${name}_error`).show().text(message);
            }

            // generate Invoice number
            function generateInvoice() {
                let invoice_number = '{{ rand(123456, 99999) }}';
                $('.generate_invoice').val(invoice_number);
                $('.invoice_number').val(invoice_number);
            }
            generateInvoice();

            // Product view function
            function showAllProduct() {
                $.ajax({
                    url: '/product/view/sale',
                    method: 'GET',
                    success: function(res) {
                        console.log(res);
                        const products = res.products;
                        $('.view_product').empty();

                        if (products.length > 0) {
                            $('.view_product').append(
                                `<option selected disabled>Select Product</option>`
                            );
                            $.each(products, function(index, product) {
                                // Calculate total stock quantity
                                const totalStock = product.stock_quantity.reduce((total,
                                    stock) => total + (stock.stock_quantity || 0), 0);
                                $('.view_product').append(
                                    `<option value="${product.id}">${product.name ?? ""} (${totalStock} pc Available)</option>`
                                );
                            });
                        } else {
                            $('.view_product').html(`
                                <option selected disabled>Please add Product</option>
                            `);
                        }
                    }
                });
            }
            showAllProduct();


            // customer view function
            function viewCustomer() {
                $.ajax({
                    url: '/get/customer',
                    method: 'GET',
                    success: function(res) {
                        const customers = res.allData;
                        // console.log(customers);
                        $('.select-customer').empty();
                        // Append the disabled "Select Product" option
                        if (customers.length > 0) {
                            $('.select-customer').append(
                                `<option selected disabled>Select Customer</option>`
                            );
                            $.each(customers, function(index, customer) {
                                $('.select-customer').append(
                                    `<option value="${customer.id}">${customer.name}(${customer.phone})</option>`
                                );
                            })
                        } else {
                            $('.select-customer').html(`
                            <option selected disable>Please add Customer</option>`)
                        }
                    }
                })
            }
            viewCustomer();

            const saveCustomer = document.querySelector('.save_new_customer');
            saveCustomer.addEventListener('click', function(e) {
                e.preventDefault();
                // alert('ok')
                let formData = new FormData($('.customerForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/add/customer',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            // console.log(res);
                            $('#customerModal').modal('hide');
                            $('.customerForm')[0].reset();
                            viewCustomer();
                            toastr.success(res.message);
                        } else {
                            // console.log(res);
                            if (res.error.name) {
                                showError('.customer_name', res.error.name);
                            }
                            if (res.error.phone) {
                                showError('.phone', res.error.phone);
                            }
                        }
                    }
                });
            })


            // calculate quantity
            let totalQuantity = 0;

            function updateTotalQuantity() {
                totalQuantity = 0;
                $('.quantity').each(function() {
                    let quantity = parseFloat($(this).val());
                    if (!isNaN(quantity)) {
                        totalQuantity += quantity;
                    }
                });
            }

            // sell edit check
            let checkSellEdit = '{{ $selling_price_edit }}';
            // discount edit check
            let discountCheck = '{{ $discount }}';

            // show Product function
            function showAddProduct(product, quantity, promotion) {
                let quantity1 = quantity || 1;
                // Check if a row with the same product ID already exists
                let existingRow = $(`.data_row${product.id}`);
                if (existingRow.length > 0) {
                    // If the row exists, update the quantity
                    let quantityInput = existingRow.find('.quantity');
                    let currentQuantity = parseInt(quantityInput.val());
                    let newQuantity = currentQuantity + 1;
                    quantityInput.val(newQuantity);
                } else {
                    console.log(product);
                    // If the row doesn't exist, add a new row
                    $('.showData').append(
                        `<tr class="data_row${product.id}" data-type='${product.name ? 'product' : 'via'}'>
                            <td>
                                <input type="text" class="form-control product_name${product.id} border-0"  name="product_name[]" readonly value="${product.name ?? product.via_product.product_name ?? ''}" />
                            </td>
                            <td>
                                <input type="hidden" class="product_id" name="product_id[]" readonly value="${product.id ?? 0}"  />
                                <input type="number" product-id="${product.id}" class="form-control unit_price product_price${product.id} ${checkSellEdit == 0 ? 'border-0' : ''}" id="product_price" name="unit_price[]" ${checkSellEdit == 0 ? 'readonly' : ''} value="${product.price ?? product.sale_price ?? 0}" />
                            </td>
                            <td>
                                <input type="number" product-id="${product.id}" class="form-control quantity productQuantity${product.id}" name="quantity[]" value="${quantity1}" />
                            </td>
                         
                            <td style="padding-top: 20px;">
                                ${
                                    discountCheck == 0 ?
                                         `<span class="mt-2">00</span>`
                                    : `<input type="number" product-id="${product.id}" class="form-control product_discount${product.id} discountProduct" name="product_discount"  value="" /> 
                                                                            <input type="hidden" product-id="${product.id}" class="form-control produt_cost${product.id} productCost" name="produt_cost"  value="${product.cost}" />`
                                }
                            </td>
                            <td>
                                 <input type="number" class="form-control product_subtotal${product.id} border-0" name="total_price[]" id="productTotal" readonly value="${(product.price ?? product.sale_price ?? 0) * quantity1}" />
                            </td>
                            <td style="padding-top: 20px;">
                                <a href="#" class="btn btn-sm btn-danger btn-icon purchase_delete" style="font-size: 8px; height: 25px; width: 25px;" data-id=${product.id}>
                                    <i class="fa-solid fa-trash-can" style="font-size: 0.8rem; margin-top: 2px;"></i>
                                </a>
                            </td>
                        </tr>`
                    );
                }
            }

            // Function to calculate the subtotal for each product
            function calculateTotal() {
                $('.quantity').each(function() {
                    let $quantityInput = $(this);
                    let productId = $quantityInput.attr('product-id');
                    let quantity = parseInt($quantityInput.val());
                    let price = parseFloat($('.product_price' + productId).val());
                    let productSubtotal = $('.product_subtotal' + productId);
                    let subtotal = quantity * price;

                    productSubtotal.val(subtotal.toFixed(2));
                    calculateProductTotal();
                });
            }

            // when product price is Edit
            $(document).on('change', '.unit_price', function() {
                let product_id = $(this).attr('product-id');
                // alert(product_id);
                let quantity = parseFloat($('.productQuantity' + product_id).val());
                let unit_price = parseFloat($(this).val());
                let productSubtotal = $('.product_subtotal' + product_id);
                let total = unit_price * quantity;

                $.ajax({
                    url: '/product/find-qty/' + product_id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status == 200) {
                            let product = res.product;
                            if (unit_price < product.price) {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "you want to sell this product at a lower price?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, I want!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        productSubtotal.val(total);
                                        calculateProductTotal();
                                        // calculateCustomerDue();
                                    } else {
                                        productSubtotal.val(total);
                                        calculateProductTotal();
                                        // calculateCustomerDue();
                                    }
                                })
                            } else {
                                productSubtotal.val(total);
                                calculateProductTotal();
                                // calculateCustomerDue();
                            }
                        }

                    }
                });
            });

            // when discount price is Edit
            $(document).on('change', '.discountProduct', function() {
                let product_id = $(this).attr('product-id');
                // alert(product_id);
                let quantity = $('.productQuantity' + product_id).val();
                let discountProduct = parseFloat($(this).val());
                let product_price = parseFloat($('.product_price' + product_id).val());
                let productSubtotal = parseFloat($('.product_subtotal' + product_id).val());
                let cost_price = parseFloat($('.produt_cost' + product_id).val());

                let subTotal = productSubtotal - discountProduct;
                // console.log(subTotal);
                // console.log(productSubtotal);
                // console.log(discountProduct);

                if (subTotal < cost_price) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "you want to sell this product at a lower price?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, I want!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('.product_subtotal' + product_id).val(subTotal);
                            calculateProductTotal();
                            // calculateCustomerDue();
                        } else {
                            $(this).val('');
                            $('.product_subtotal' + product_id).val(product_price);
                        }
                    })
                } else {
                    $('.product_subtotal' + product_id).val(subTotal);
                    calculateProductTotal();
                    // calculateCustomerDue();
                }
            });





            // Function to calculate the grand total from all products
            function calculateProductTotal() {
                let allProductTotal = document.querySelectorAll('#productTotal');
                let allTotal = 0;
                allProductTotal.forEach(product => {
                    let productValue = parseFloat(product.value);
                    if (!isNaN(productValue)) {
                        allTotal += productValue;
                    }
                });
                $('.grandTotal').val(allTotal.toFixed(2));
                $('.total').val(allTotal.toFixed(2));
                $('.grand_total').val(allTotal.toFixed(2));
            }
            calculateProductTotal();

            // Function to update grand total when a product is added or deleted
            function updateGrandTotal() {
                calculateTotal();
                updateTotalQuantity();
                calculateProductTotal();
            }

            // Product add with barcode
            $('.barcode_input').change(function() {
                let barcode = $(this).val();
                $.ajax({
                    url: '/product/barcode/find/' + barcode,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status == 200) {
                            const product = res.data;
                            const promotion = res.promotion;
                            showAddProduct(product, 1, promotion);
                            updateGrandTotal();
                            // calculateCustomerDue();
                            $('.barcode_input').val('');
                        } else {
                            toastr.warning(res.error);
                            $('.barcode_input').val('');
                        }
                    }
                });
            });

            // Select product
            $('.product_select').change(function() {
                let id = $(this).val();
                let customer_id = $('.select-customer').val();
                if (customer_id != null) {
                    if ($(`.data_row${id}`).length === 0 && id) {
                        $.ajax({
                            url: '/product/find/' + id,
                            type: 'GET',
                            dataType: 'JSON',
                            success: function(res) {
                                const product = res.data;
                                const promotion = res.promotion;
                                showAddProduct(product, 1, promotion);
                                updateGrandTotal();
                                // calculateCustomerDue();
                            }
                        });
                    }
                } else {
                    toastr.warning('Please select a Customer');
                }

            });

            // Purchase delete
            $(document).on('click', '.purchase_delete', function(e) {
                let id = $(this).attr('data-id');
                let dataRow = $('.data_row' + id);
                dataRow.remove();
                updateGrandTotal();
                updateTotalQuantity();
                // calculateCustomerDue();
            });

            // Customer Due Calculation
            // function calculateCustomerDue() {
            //     let id = $('.select-customer').val();
            //     $.ajax({
            //         url: `/sale/customer/due/${id}`,
            //         type: 'GET',
            //         dataType: 'JSON',
            //         success: function(res) {
            //             // console.log(res)
            //             const customer = res.customer;
            //             const grand_total = parseFloat($('.grand_total').val());
            //             // const grandTotal = $('.grandTotal').val();
            //             const customerDue = parseFloat(customer.wallet_balance);
            //             // console.log(customer.wallet_balance);

            //             if (customerDue > 0) {
            //                 // console.log(`customerDue > 0 : ${customer.wallet_balance}`);
            //                 $('.previous_due').val(customerDue);
            //                 let amount = grand_total + (customerDue);
            //                 $('.grandTotal').val(amount);
            //             } else {
            //                 // console.log(customer.wallet_balance);
            //                 $('.grandTotal').val(grand_total);
            //                 $('.previous_due').val(0);
            //             }
            //         }
            //     })

            // }
            // calculateCustomerDue();


            // handson discount calculation
            $(document).on('keyup', '.handsOnDiscount', function() {
                // alert('Ok');
                let discountPrice = parseFloat($(this).val());
                let total = parseFloat($('.total').val());
                let grandTotalAmount = total - discountPrice;
                if (discountPrice > total) {
                    toastr.warning('The Discount is higher than the Total amount');
                    $(this).val('');
                    $('.grand_total').val(total);
                    $('.grandTotal').val(total);

                } else if ($(this).val() === '') {
                    $('.grand_total').val(total);
                    $('.grandTotal').val(total);
                } else {
                    $('.grand_total').val(grandTotalAmount);
                    $('.grandTotal').val(grandTotalAmount);
                    // calculateCustomerDue();
                }
            })


            // quantity
            $(document).on('keyup', '.quantity', function(e) {
                e.preventDefault();
                let id = $(this).attr("product-id")
                let quantity = $(this).val();
                quantity = parseInt(quantity);
                let subTotal = $('.product_subtotal' + id);
                if (quantity < 0) {
                    toastr.warning('quantity must be positive value');
                    $(this).val('');
                } else {
                    $.ajax({
                        url: `/product/find-qty/${id}`,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            let stock = res.product.stock;
                            let productPrice = res.product.price;
                            if (quantity > stock) {
                                updateGrandTotal();
                                // calculateCustomerDue();
                                toastr.success(
                                    `Your Product Quantity is ${stock}. You are selling additional products through Via Sell`
                                )
                            } else {
                                updateGrandTotal();
                                // calculateCustomerDue();
                            }
                        }
                    })
                }
            })


            // Customer Due
            $(document).on('change', '.select-customer', function() {
                // calculateCustomerDue();
            })

            // total_payable
            $('.total_payable').keyup(function(e) {
                totalDue();
            })

            // due
            function totalDue() {
                let pay = $('.total_payable').val();
                let grandTotal = parseFloat($('.grandTotal').val());
                let due = (grandTotal - pay).toFixed(2);
                if (due > 0) {
                    $('.total_due').val(due);
                    $('.due_text').text('Due');
                } else {
                    $('.total_due').val(-(due));
                    $('.due_text').text('Return');
                }
            }


            $('.tax').change(function() {
                let grandTotal = parseFloat($('.grand_total').val());
                let value = parseInt($(this).val());
                // alert(value);

                let taxTotal = (grandTotal * value) / 100;
                taxTotal = (taxTotal + grandTotal).toFixed(2);
                // $('.grandTotal').text(taxTotal);
                $('.grandTotal').val(taxTotal);
                // $('.total_payable').val(taxTotal);
            })

            let checkPrintType = '{{ $invoice_type }}';
            // console.log(checkPrintType);

            function saveInvoice() {
                let customer_id = $('.select-customer').val();
                let sale_date = $('.purchase_date').val();
                let formattedSaleDate = moment(sale_date, 'DD-MMM-YYYY').format('YYYY-MM-DD HH:mm:ss');
                let quantity = totalQuantity;
                let total_amount = parseFloat($('.total').val());
                // let discount = $('.discount_field').val();
                let total = parseFloat($('.grand_total').val());
                let tax = $('.tax').val();
                let change_amount = parseFloat($('.grandTotal').val());
                let actual_discount = parseFloat($('.handsOnDiscount').val()) || 0;
                let paid = parseFloat($('.total_payable').val()) || 0;
                let due = change_amount - paid;
                let note = $('.note').val();
                let payment_method = $('.payment_method').val();
                let previous_due = $('.previous_due').val();
                let invoice_number = $('.generate_invoice').val();
                // let product_id = $('.product_id').val();
                // console.log(total_quantity);

                let products = [];

                $('tr[class^="data_row"]').each(function() {
                    let row = $(this);
                    // Get values from the current row's elements
                    let product_id = row.find('.product_id').val();
                    let quantity = row.find('input[name="quantity[]"]').val();
                    let unit_price = row.find('input[name="unit_price[]"]').val();
                    let wa_status = row.find(`.warranty_status${product_id}`).is(':checked') ? 1 : 0;
                    let wa_duration = row.find(`.wa_duration${product_id}`).val();
                    let discount_amount = row.find(`.discount_amount${product_id}`).text().replace('Tk',
                        '') || 0;
                    let discount_percentage = row.find(`.discount_percentage${product_id}`).text().replace(
                        '%', '') || 0;
                    let productDiscount = row.find(`.product_discount${product_id}`).val();
                    let total_price = row.find('input[name="total_price[]"]').val();
                    // console.log(productDiscount);
                    let product_discount = discount_amount || discount_percentage ? (discount_amount ?
                        discount_amount : discount_percentage) : (productDiscount ? productDiscount : 0);

                    let dataType = row.data('type');
                    let product = {
                        product_id,
                        quantity,
                        unit_price,
                        wa_status,
                        wa_duration,
                        product_discount,
                        total_price,
                        dataType
                    };

                    // Push the object into the products array
                    products.push(product);
                });

                let allData = {
                    // for purchase table
                    customer_id,
                    sale_date: formattedSaleDate,
                    quantity,
                    total_amount,
                    actual_discount,
                    total,
                    change_amount,
                    tax,
                    paid,
                    due,
                    note,
                    payment_method,
                    products,
                    previous_due,
                    invoice_number
                }

                // console.log(allData);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/sale/store',
                    type: 'POST',
                    data: allData,
                    success: function(res) {
                        if (res.status == 200) {
                            toastr.success(res.message);
                            let id = res.saleId;
                            // window.location.href = '/sale/print/' + id;
                            var printFrame = $('#printFrame')[0];

                            if (checkPrintType == 'a4' || checkPrintType == 'a5') {
                                var printContentUrl = '/sale/invoice/' + id;
                                $('#printFrame').attr('src', printContentUrl);

                                printFrame.onload = function() {
                                    printFrame.contentWindow.focus();
                                    printFrame.contentWindow.print();
                                    // Redirect after printing
                                    printFrame.contentWindow.onafterprint = function() {
                                        window.location.href = "/sale";
                                    };
                                };
                            } else {
                                var printContentUrl = '/sale/print/' + id;
                                $('#printFrame').attr('src', printContentUrl);

                                printFrame.onload = function() {
                                    printFrame.contentWindow.focus();
                                    printFrame.contentWindow.print();
                                    // Redirect after printing
                                    printFrame.contentWindow.onafterprint = function() {
                                        window.location.href = "/sale";
                                    };
                                };
                            }

                            $(window).off('beforeunload');
                        } else {
                            // console.log(res);
                            if (res.error.customer_id) {
                                showError('.select-customer', res.error.customer_id);
                            }
                            if (res.error.sale_date) {
                                showError('.purchase_date', res.error.sale_date);
                            }
                            if (res.error.payment_method) {
                                showError('.payment_method', res.error.payment_method);
                            }
                            if (res.error.paid) {
                                showError('.total_payable', res.error.paid);
                            }
                            if (res.error.products) {
                                toastr.warning("Please Select a Product to sell");
                            }
                        }
                    }
                });
            }

            const total_payable = document.querySelector('.total_payable');
            total_payable.addEventListener('keydown',
                function(e) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        saveInvoice();
                    }
                })
            // order btn
            $('.payment_btn').click(function(e) {
                e.preventDefault();
                saveInvoice();
            })
        })
    </script>
@endsection
