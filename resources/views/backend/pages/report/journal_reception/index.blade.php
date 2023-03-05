
@extends('backend.layouts.master')

@section('title')
@lang('Journal des receptions') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('Journal des receptions')</h4>
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
                    <h4 class="header-title float-left">Journal des receptions</h4>
                <form action="{{ route('admin.journalReception.export')}}" method="GET">
                    <p class="float-right mb-2">
                        <button type="submit" class="btn btn-success">Exporter En Excel</button>
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
                                    <th width="5%">#</th>
                                    <th width="10%">@lang('messages.date')</th>
                                    <th width="10%">Reception No</th>
                                    <th width="10%">@lang('messages.item')</th>
                                    <th width="10%">@lang('messages.specification')</th>
                                    <th width="10%">@lang('messages.quantity')</th>
                                    <th width="10%">@lang('messages.unit_price')</th>
                                    <th width="10%">@lang('messages.supplier')</th>
                                    <th width="10%">@lang('messages.invoice_no')</th>
                                    <th width="10%">Commande No</th>
                                    <th width="10%">@lang('messages.total_value')</th>
                                    <th width="10%">Receptioniste</th>
                                    <th width="10%">@lang('messages.created_by')</th>
                                    <th width="20%">@lang('messages.description')</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($journalReceptions as $reception)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $reception->date }}</td>
                                    <td>{{ $reception->reception_no }}</td>
                                    <td>{{ $reception->article->name }}</td>
                                    <td>{{ $reception->article->specification }}</td>
                                    <td>{{ $reception->quantity }}@if($reception->status == 1)<img src="{{ asset('img/warning3.gif')}}" width="35">@endif</td>
                                    <td>{{ number_format($reception->unit_price,0,',','.' ) }} fbu</td>
                                    <td>{{ $reception->supplier }}</td>
                                    <td>{{ $reception->invoice_no }}</td>
                                    <td><a href="@if($reception->commande_no){{ route('admin.orders.show',$reception->commande_no)}} @endif">{{ $reception->commande_no }}</a></td>
                                    <td>{{ number_format($reception->total_value,0,',','.' ) }} fbu</td>
                                    <td>{{ $reception->receptionist }}</td>
                                    <td>{{ $reception->created_by }}</td>
                                    <td>{{ $reception->description }}</td>
                                    <td>
                                       
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