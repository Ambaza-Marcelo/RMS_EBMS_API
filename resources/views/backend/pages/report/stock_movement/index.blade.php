
@extends('backend.layouts.master')

@section('title')
@lang('journal Général') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('journal Général')</h4>
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
                    <h4 class="header-title float-left">@lang('journal Général')</h4>
                    <form action="{{ route('admin.stock.movement.export')}}" method="GET">
                        <p class="float-right mb-2">
                            <button type="submit" value="search" title="Cliquer pour exporter en Excel" class="btn btn-primary">Exporter En Excel</button>
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
                    <form action="{{ route('admin.stock.movement.pdf')}}" method="GET">
                        <p class="float-right mb-2">
                            <button type="submit" value="pdf" class="btn btn-info">Exporter En PDF</button>
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
                                    <th width="10%">@lang('messages.item')</th>
                                    <th width="10%">@lang('messages.specification')</th>
                                    <th width="10%">@lang('messages.category')</th>
                                    <th width="10%">Q. S. Initial</th>
                                    <th width="10%">Q. Entree</th>
                                    <th width="10%">Q. S. Total</th>
                                    <th width="10%">Q. Sortie/Vente</th>
                                    <th width="10%">Demandeur</th>
                                    <th width="10%">Bon Sortie/Facture No</th>
                                    <th width="10%">@lang('messages.created_by')</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($stockMovements as $stockMovement)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($stockMovement->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $stockMovement->article->name }} </td>
                                    <td>{{ $stockMovement->article->specification }} </td>
                                    <td>{{ $stockMovement->article->category->name }} </td>
                                    <td>{{ $stockMovement->quantity_stock_initial }} </td>
                                    <td>{{ $stockMovement->quantity_stockin }} </td>
                                    <td>{{ $stockMovement->stock_total }} </td>
                                    <td>@if($stockMovement->quantity_stockout){{ $stockMovement->quantity_stockout }} @elseif($stockMovement->quantity_sold) {{ $stockMovement->quantity_sold }} @endif </td>
                                    <td>{{ $stockMovement->asker }} </td>
                                    <td><a href="@if($stockMovement->bon_sortie){{ route('admin.stockouts.show',$stockMovement->bon_sortie)}} @endif">{{ $stockMovement->bon_sortie }}</a></td>
                                    <td>{{ $stockMovement->created_by }} </td>
                                    <td></td>
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