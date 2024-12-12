@extends('master')
@section('title', '| Money Receipt')
@section('admin')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card filter_box">
            <div class="card">
                <div class="card-body">
                    <div class="show_doc">
                        @switch($type)
                            @case('movement')
                                @if ($movementCost->image)
                                    @php
                                        $fileExtension = strtolower(pathinfo($movementCost->image, PATHINFO_EXTENSION));
                                    @endphp

                                    @if ($fileExtension !== 'pdf')
                                        <!-- If the document is an image -->
                                        <img id="printableImage" src="{{ asset('uploads/movement_costs/' . $movementCost->image) }}" width="100%" height="500px" alt="Image" />
                                        <button class="btn btn-primary mt-3" id="printImageBtnMovement">
                                            <i class="fa-solid fa-print"></i> Print
                                        </button>
                                    @else
                                        <!-- If the document is a PDF -->
                                        <iframe src="{{ asset('uploads/movement_costs/' . $movementCost->image) }}" width="100%" height="500px"></iframe>
                                    @endif
                                @else
                                    <p>No document available</p>
                                @endif
                                @break

                            @case('fooding')
                                @if ($foodingCost->image)
                                    @php
                                        $fileExtension = strtolower(pathinfo($foodingCost->image, PATHINFO_EXTENSION));
                                    @endphp

                                    @if ($fileExtension !== 'pdf')
                                        <!-- If the document is an image -->
                                        <img id="printableImage2" src="{{ asset('uploads/fooding_costs/' . $foodingCost->image) }}" width="100%" height="500px" alt="Image" />
                                        <button class="btn btn-primary mt-3" id="printImageBtnFooding">
                                            <i class="fa-solid fa-print"></i> Print
                                        </button>
                                    @else
                                        <!-- If the document is a PDF -->
                                        <iframe src="{{ asset('uploads/fooding_costs/' . $foodingCost->image) }}" width="100%" height="500px"></iframe>
                                    @endif
                                @else
                                    <p>No document available</p>
                                @endif
                                @break

                            @case('overnight')
                                @if ($overnightCost->image)
                                    @php
                                        $fileExtension = strtolower(pathinfo($overnightCost->image, PATHINFO_EXTENSION));
                                    @endphp

                                    @if ($fileExtension !== 'pdf')
                                        <!-- If the document is an image -->
                                        <img id="printableImage3" src="{{ asset('uploads/overnight_costs/' . $overnightCost->image) }}" width="100%" height="500px" alt="Image" />
                                        <button class="btn btn-primary mt-3" id="printImageBtnOvernight">
                                            <i class="fa-solid fa-print"></i> Print
                                        </button>
                                    @else
                                        <!-- If the document is a PDF -->
                                        <iframe src="{{ asset('uploads/overnight_costs/' . $overnightCost->image) }}" width="100%" height="500px"></iframe>
                                    @endif
                                @else
                                    <p>No document available</p>
                                @endif
                                @break

                            @case('other')
                                @if ($otherCost->image)
                                    @php
                                        $fileExtension = strtolower(pathinfo($otherCost->image, PATHINFO_EXTENSION));
                                    @endphp

                                    @if ($fileExtension !== 'pdf')
                                        <!-- If the document is an image -->
                                        <img id="printableImage4" src="{{ asset('uploads/other_expense_costs/' . $otherCost->image) }}" width="100%" height="500px" alt="Image" />
                                        <button class="btn btn-primary mt-3" id="printImageBtnOther">
                                            <i class="fa-solid fa-print"></i> Print
                                        </button>
                                    @else
                                        <!-- If the document is a PDF -->
                                        <iframe src="{{ asset('uploads/other_expense_costs/' . $otherCost->image) }}" width="100%" height="500px"></iframe>
                                    @endif
                                @else
                                    <p>No document available</p>
                                @endif
                                @break

                            @default
                                <p>Invalid Type</p>
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav,
            .footer {
                display: none !important;
            }

            button {
                display: none !important;
            }

            img {
                max-width: 100% !important;
                height: auto !important;
            }

            .show_doc {
                display: block !important;
            }
        }
    </style>

<script>
   // Generic function to handle print
function handlePrintButtonClick(type, id) {
    $.ajax({
        url: `/${type}-cost/image/` + id,
        method: 'GET',
        success: function(res) {
            if (res.status == 200) {
                // Open the PDF in a new tab using iframe
                var newWindow = window.open();
                newWindow.document.write('<iframe src="' + res.data + '" width="100%" height="100%"></iframe>');
            } else {
                toastr.warning('Something went wrong');
            }
        }
    });
}

// Dynamic print button handling for movement, fooding, overnight, and other
document.getElementById('printImageBtnMovement')?.addEventListener('click', function() {
    let id = '{{ $movementCost->id ?? '' }}';
    if (id) {
        handlePrintButtonClick('movement', id);
    }
});

document.getElementById('printImageBtnFooding')?.addEventListener('click', function() {
    let id = '{{ $foodingCost->id ?? '' }}';
    if (id) {
        handlePrintButtonClick('fooding', id);
    }
});

document.getElementById('printImageBtnOvernight')?.addEventListener('click', function() {
    let id = '{{ $overnightCost->id ?? '' }}';
    if (id) {
        handlePrintButtonClick('overnight', id);
    }
});

document.getElementById('printImageBtnOther')?.addEventListener('click', function() {
    let id = '{{ $otherCost->id ?? '' }}';
    if (id) {
        handlePrintButtonClick('other', id);
    }
});
</script>
@endsection
