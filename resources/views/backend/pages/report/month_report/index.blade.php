
@extends('backend.layouts.master')

@section('title')
@lang('Rapport stock des materiels de bureau') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('Rapport stock des Materiels de Bureau')</h4>
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
                    <h4 class="header-title float-left">Rapport stock des Materiels de bureau</h4>
                <form action="{{ route('admin.report.stock.month.pdf')}}" method="GET">
                    <p class="float-right mb-2">
                        <button type="submit" class="btn btn-info">PDF</button>
                    </p>
                    <p class="float-right mb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>
                    </p>
                </form>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>@lang('messages.item')</th>
                                    <th>@lang('messages.specification')</th>
                                    <th>C.U.M.P</th>
                                    <th style="background-color: rgb(150,150,150);">Stock Initial</th>
                                    <th>Entrée</th>
                                    <th style="background-color: rgb(150,150,150);">Stock Total</th>
                                    <th>Sortie</th>
                                    <th>Destination</th>
                                    <th style="background-color: rgb(150,150,150);">S. Final</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($reportMonths as $reportMonth)
                               <tr>
                                   <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $reportMonth->month }}/{{ $reportMonth->year }}</td>
                                    <td>{{ $reportMonth->article->name }}</td>
                                    <td>{{ $reportMonth->article->specification }}</td>
                                    <td>{{ number_format($reportMonth->article->unit_price,0,',','.') }}fbu</td>
                                    <td style="background-color: rgb(150,150,150);">{{ $reportMonth->quantity_stock_init }}</td>
                                    <td>{{ $reportMonth->quantity_in }}</td>
                                    @php $stockTotal = $reportMonth->quantity_stock_init + $reportMonth->quantity_in
                                    @endphp
                                    <td style="background-color: rgb(150,150,150);">{{ $stockTotal }}</td>
                                    <td>{{ $reportMonth->quantity_out }}</td>
                                    <td>@if($reportMonth->service_id){{ $reportMonth->service->name }}@endif</td>
                                    <td style="background-color: rgb(150,150,150);">{{ $stockTotal - $reportMonth->quantity_out }}</td>
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