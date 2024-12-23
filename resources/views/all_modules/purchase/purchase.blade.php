@extends('master')
@section('title', '| Add Purchase')
@section('admin')
    <style>
        .input-small {
            width: 100px;
        }
    </style>
    {{-- @foreach ($products as $product)
        @dd($product->id);
    @endforeach --}}
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Purchase Products</li>
        </ol>
    </nav>
    <form id="purchaseForm" class="row" enctype="multipart/form-data">
        {{-- form  --}}
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title">Purchase Products</h6>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="ageSelect" class="form-label">Supplier <span
                                        class="text-danger">*</span></label>
                                <select class="js-example-basic-single form-select select-supplier supplier_id"
                                    data-width="100%" name="supplier_id">
                                </select>
                                <span class="text-danger supplier_id_error"></span>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Purchase Date</label>
                                <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                    <span class="input-group-text input-group-addon bg-transparent border-primary"
                                        data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                    <input type="text" name="date"
                                        class="form-control bg-transparent border-primary purchase_date"
                                        placeholder="Select date" data-input>
                                </div>
                                <span class="text-danger purchase_date_error"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="ageSelect" class="form-label">Products <span
                                        class="text-danger">*</span></label>
                                <select class="js-example-basic-single form-select product_select" data-width="100%"
                                    onclick="errorRemove(this);">
                                    @if ($products->count() > 0)
                                        <option selected disabled>Select Products</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name ?? '' }}
                                                ({{ $product->stockQuantity->sum('stock_quantity') ?? 0 }}
                                                {{ $product->unit->name ?? '' }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option selected disabled>
                                            Please Add Product</option>
                                    @endif
                                </select>
                                <span class="text-danger product_select_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="formFile">Invoice File/Picture upload</label>
                                <input class="form-control document_file" name="document" type="file" id="formFile"
                                    onclick="errorRemove(this);">
                                <span class="text-danger document_file_error"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="formFile">Invoice Number</label>
                                <input class="form-control" name="invoice" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- table  --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="card-title">Purchase Table</h6>
                        </div>
                        <div class="mb-2">
                            <p class="text-danger">Sell Price must be greater than Cost Price</p>
                        </div>

                        <div id="" class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#SL</th>
                                        <th>Product</th>
                                        <th>Cost Price</th>
                                        <th>Sell Price</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                        <th>
                                            <i class="fa-solid fa-trash-can"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="showData">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    Total :
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" class="form-control total border-0 "
                                                        name="total" readonly value="0.00" />
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    Carrying Cost :
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" class="form-control carrying_cost"
                                                        name="carrying_cost" onkeyup="calculateTotal();" value="0.00" />
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    Sub Total :
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" class="form-control grand_total border-0 "
                                                        name="sub_total" readonly value="0.00" />
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="my-3">
                            <button type="submit" class="btn btn-primary payment_btn" disabled><i
                                    class="fa-solid fa-money-check-dollar"></i>
                                Payment</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>




    <script>
        // remove error
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

        // Function to recalculate total and check sell price
        // Function to recalculate total, check sell price, and update total quantity
        let totalQuantity = 0;

        function calculateTotal() {
            let total = 0;


            $('.quantity').each(function() {
                let productId = $(this).attr('product-id');
                let qty = parseFloat($(this).val()) || 1;
                let cost = parseFloat($('.product_price' + productId).val()) || 0;
                let price = parseFloat($('.sell_price' + productId).val()) || 0;

                // Calculate and update subtotal
                let subtotal = qty * cost;
                $('.product_subtotal' + productId).val(subtotal.toFixed(2));
                total += subtotal;

                // Update total quantity
                totalQuantity += qty;

                // Check sell price
                if (cost > price) {
                    $('.sell_price' + productId).css('border-color', 'red');
                    $(`.sell_price${productId}_error`).show().text('Sell Price must be greater than Cost Price');
                    $('.payment_btn').prop('disabled', true);
                } else {
                    $('.sell_price' + productId).css('border-color', 'green');
                    $(`.sell_price${productId}_error`).hide();
                    $('.payment_btn').prop('disabled', false);
                }
            });

            // Update total and grand total
            $('.total').val(total.toFixed(2));
            let carrying_cost = parseFloat($('.carrying_cost').val()) || 0;
            $('.grand_total').val((carrying_cost + total).toFixed(2));

            // Optionally, update total quantity display (if needed)
            // console.log('Total Quantity:', totalQuantity);
        }



        $(document).ready(function() {
            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }


            // show supplier
            function supplierView() {
                // console.log('hello')
                $.ajax({
                    url: '/supplier/view',
                    method: 'GET',
                    success: function(res) {
                        const suppliers = res.data;
                        // console.log(suppliers);
                        $('.select-supplier').empty();
                        if (suppliers.length > 0) {
                            $('.select-supplier').html(
                                `<option selected disabled>Select a Supplier</option>`);
                            $.each(suppliers, function(index, supplier) {
                                $('.select-supplier').append(
                                    `<option value="${supplier.id}">${supplier.name}</option>`
                                );
                            })
                        } else {
                            $('.select-supplier').html(`
                                <option selected disable>Please add supplier</option>`)
                        }
                    }
                })
            }
            supplierView();

            // Function to update SL numbers
            function updateSLNumbers() {
                $('.showData > tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }


            // select product
            $('.product_select').change(function() {
                let id = $(this).val();
                let supplier = $('.select-supplier').val();

                if (supplier) {
                    if ($(`.data_row${id}`).length === 0 && id) {
                        $.ajax({
                            url: '/product/find/' + id,
                            type: 'GET',
                            dataType: 'JSON',
                            success: function(res) {
                                if (res.status == 200) {
                                    const product = res.data;
                                    $('.showData').append(
                                        `<tr class="data_row${product.id}">
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control product_name${product.id} border-0" name="product_name[]" readonly value="${product.name ?? ""}" />
                                    </td>
                                    <td>
                                        <input type="hidden" class="product_id" name="product_id[]" readonly value="${product.id ?? 0}" />
                                        <input type="number" class="form-control product_price${product.id} input-small" name="unit_price[]" onkeyup="calculateTotal();" value="${Math.round(product.cost) ?? 0}" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control sell_price${product.id} input-small mb-0" name="sell_price[]" onkeyup="calculateTotal();" value="${Math.round(product.price) ?? 0}" />
                                        <span class="text-danger sell_price${product.id}_error" style="font-size: 10px;"></span>
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <input type="number" product-id="${product.id}" class="form-control input-small quantity me-3" onkeyup="calculateTotal();" name="quantity[]" value="1" />
                                            <span>${product?.unit?.name}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control product_subtotal${product.id} border-0" name="total_price[]" readonly value="00.00" />
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-icon purchase_delete" data-id=${product.id}>
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>`
                                    );

                                    // Update SL numbers
                                    updateSLNumbers();
                                    calculateTotal();

                                    $('.payment_btn').prop('disabled', false);
                                } else {
                                    toastr.warning(res.message);
                                }
                            }
                        });
                    }
                } else {
                    showError('.supplier_id', 'Please Select Supplier');
                }
            });



            // purchase Delete
            $(document).on('click', '.purchase_delete', function(e) {
                // alert('ok');
                let id = $(this).attr('data-id');
                let dataRow = $('.data_row' + id);
                dataRow.remove();
                // Recalculate grand total
                calculateTotal();
                updateSLNumbers();
            });

            // payment button click event
            $('.payment_btn').click(function(e) {
                e.preventDefault();
                // alert('ok');
                // let cumtomer_due = parseFloat($('.previous_due').text());
                // let subtotal = parseFloat($('.grand_total').val());
                // $('.subTotal').val(subtotal);
                // let grandTotal = cumtomer_due + subtotal;
                // $('.grandTotal').val(grandTotal);
                // $('.paying_items').text(totalQuantity);

                var isValid = true;
                //Quantity Message
                $('.quantity').each(function() {
                    var quantity = $(this).val();
                    if (!quantity || quantity < 1) {
                        isValid = false;
                        return false;
                    }
                });
                if (!isValid) {
                    event.preventDefault();
                    // alert('Please enter a quantity of at least 1 for all products.');
                    toastr.error('Please enter a quantity of at least 1.)');
                    // $('#paymentModal').modal('hide');
                } else {
                    let formData = new FormData($('#purchaseForm')[0]);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/purchase/store',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res.status == 200) {
                                $('#globalPaymentModal #data_id').val(res.data.id);
                                $('#globalPaymentModal #payment_balance').val(res.data
                                    .grand_total);
                                $('#globalPaymentModal #purpose').val('Product Purchase');
                                $('#globalPaymentModal #transaction_type').val('withdraw');
                                $('#globalPaymentModal #due-amount').text(res.data.grand_total);
                                // Open the Payment Modal
                                $('#globalPaymentModal').modal('show');
                            } else {
                                if (res.error.supplier_id) {
                                    showError('.supplier_id', res.error.supplier_id);
                                }
                                if (res.error.purchase_date) {
                                    showError('.purchase_date', res.error.purchase_date);
                                }
                                if (res.error.document) {
                                    showError('.document_file', res.error.document);
                                }
                            }
                        }
                    });
                }
            })
        });
    </script>

@endsection
