@extends('master')
@section('title', '| Expense')
@section('admin')
    <div class="row">

        <div id="filter-rander">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-info">Convenience Bill Report</h6>
                        <div id="tableContainer" class="table-responsive">
                            <table id="example" class="table">
                                <thead class="action">
                                    <tr>
                                        <th>SN</th>
                                        <th>Invoice No.</th>
                                        <th>Employee Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="showData">

                                    @if ($convenience->count() > 0)
                                    @foreach ($convenience as $key =>  $item)
                                    <tr>
                                     <td>{{ $key + 1 }}</td>
                                     <td><a href="{{route('convenience.invoice',$item->id)}}">{{$item->bill_number}}</a></td>
                                     <td>{{$item->employee->full_name }}</td>
                                     <td>{{$item->total_amount }}</td>
                                     <td>
                                        @if ($item->status  == 1)
                                        <a href="" class="btn btn-sm bg-success">Active </a>
                                        @else
                                        <a href="" class="btn btn-sm bg-warning">Inctive</a>
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12">
                                                <div class="text-center text-warning mb-2">Data Not Found</div>
                                                <div class="text-center">
                                                    <a href="#" class="btn btn-primary">Add Convenience<i
                                                            data-feather="plus"></i></a>
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
    </div>
    {{-- /////Expensse Report End --}}
    </div>
    </div>



    </div>

@endsection
