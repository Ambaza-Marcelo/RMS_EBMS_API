
@extends('backend.layouts.master')

@section('title')
@lang('messages.stockout') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.stockout')</h4>
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
                    <h4 class="header-title float-left">@lang('messages.stockout')</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('stockout.create'))
                            <a class="btn btn-success text-white" href="{{ route('admin.stockout.export') }}" title="Exporter en Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                            <a class="btn btn-primary text-white" href="{{ route('admin.stockouts.create') }}" title="Sortie">@lang('messages.new')</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Bon No</th>
                                    <th width="10%">@lang('messages.date')</th>
                                    <th width="10%">@lang('messages.asker')</th>
                                    <th width="20%">@lang('messages.description')</th>
                                    <th width="10%">@lang('messages.created_by')</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($stockouts as $stockout)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td><a href="@if($stockout->bon_no){{ route('admin.stockouts.show',$stockout->bon_no)}} @endif">{{ $stockout->bon_no }} </a></td>
                                    <td>{{ $stockout->date }}</td>
                                    <td>{{ $stockout->asker }}</td>
                                    <td>{{ $stockout->observation }}</td>
                                    <td>{{ $stockout->created_by }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('stockout.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.stockouts.edit', $stockout->bon_no) }}">@lang('messages.edit')</a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('stockout.edit'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.stockouts.destroy', $stockout->bon_no) }}" 
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $stockout->bon_no }}').submit();"  onclick="return confirm('Etes-vous d\'accord pour supprimer le bon de sortie no : {{$stockout->bon_no}}?');" >
                                                @lang('messages.delete')
                                            </a>

                                            <form id="delete-form-{{ $stockout->bon_no }}" action="{{ route('admin.stockouts.destroy', $stockout->bon_no) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('bon_sortie.create'))
                                        <a href="{{ route('admin.stockouts.bon_sortie',$stockout->bon_no) }}"><img src="{{ asset('img/ISSh.gif') }}" width="60" title="Télécharger d'abord le document et puis imprimer"></a>
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


     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
     
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