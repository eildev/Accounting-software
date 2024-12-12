@extends('master')
@section('title', '| Service View')
@section('admin')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card ">
                <div class="card-body">
                    <div class="col-md-12 grid-margin stretch-card d-flex  mb-0 justify-content-between">
                        <div>

                        </div>
                        <div class="">
                            <h4 class="text-right"><a href="{{ route('service.sale') }}" class="btn"
                                    style="background: #5660D9">Add Service Sale</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2">Service Sale list</h4>
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Volume</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($serviceSales->count() > 0)
                                    @foreach ($serviceSales as $key => $serviceSale)
                                        <tr>

                                            <td>
                                                <a href="{{ route('') }}">
                                                    #{{ $serviceSale->invoice_number ?? '' }}
                                                </a>
                                            </td>
                                            <td>{{ $serviceSale->customer->name ?? '' }}</td>
                                            <td>{{ $serviceSale->date ?? '' }}</td>
                                            <td>{{ $serviceSale->name ?? '' }}</td>
                                            <td>{{ $serviceSale->volume ?? '' }}</td>
                                            <td>{{ $serviceSale->price ?? '' }}</td>
                                            <td>{{ $serviceSale->total ?? '' }}</td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            <div class="text-center text-warning mb-2">Data Not Found</div>
                                            <div class="text-center">
                                                <a href="{{ route('service.sale') }}" class="btn btn-primary">Add Service
                                                    Sale<i data-feather="plus"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
