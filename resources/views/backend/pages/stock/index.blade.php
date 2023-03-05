
@extends('backend.layouts.master')

@section('title')
@lang('messages.virtualstock') - @lang('messages.admin_panel')
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.virtualstock')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><span>@lang('messages.list')</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">@lang('messages.virtualstock')</h4>
                    <p class="float-right mb-2">
                        <a class="btn btn-info text-white" href="{{ route('admin.stock-status') }}" title="Exporter en pdf l'état du stock"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a>
                        <a class="btn btn-success text-white" href="{{ route('admin.stock.export') }}" title="Exporter en Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">@lang('messages.item')</th>
                                    <th width="10%">@lang('messages.specification')</th>
                                    <th width="10%">@lang('messages.quantity')</th>
                                    <th width="10%">@lang('messages.threshold_quantity')</th>
                                    <th width="10%">@lang('messages.unit_price')</th>
                                    <th width="10%">@lang('messages.total_value')</th>
                                    <th width="10%">@lang('messages.expiration_date')</th>
                                    <th width="10%">@lang('messages.date')</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($stocks as $stock)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $stock->article->name }}</td>
                                    <td>{{ $stock->article->specification }}</td>
                                    @if($stock->quantity <= $stock->article->threshold_quantity)
                                    <td>{{ $stock->quantity }}<img src="{{ asset('img/warning.gif')}}" width="30"></td>
                                    @else
                                    <td>{{ $stock->quantity }}</td>
                                    @endif
                                    <td>{{ $stock->article->threshold_quantity }}</td>
                                    <td>{{ number_format($stock->article->unit_price,0,',','.' ) }}</td>
                                    <td>{{ number_format($stock->total_value,0,',','.' )}} fbu</td>
                                    <td>@if(\Carbon\Carbon::parse(now())->format('dmY') >= \Carbon\Carbon::parse($stock->article->expiration_date)->format('dmY'))<img src="{{ asset('img/AZau.gif')}}" width="30">@endif{{ \Carbon\Carbon::parse($stock->article->expiration_date)->format('d/m/Y') }}</td>
                                    <td>{{ $stock->created_at }}</td>
                                    <td>
                                    @if (Auth::guard('admin')->user()->can('stock.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.stocks.destroy', $stock->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $stock->id }}').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-form-{{ $stock->id }}" action="{{ route('admin.stocks.destroy', $stock->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection


@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
     
     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

     </script>
@endsection