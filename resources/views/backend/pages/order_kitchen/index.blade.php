
@extends('backend.layouts.master')

@section('title')
@lang('Commande Cuisine') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('Commande Cuisine')</h4>
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
                    <h4 class="header-title float-left">Commande Cuisine</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('order_kitchen.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.order_kitchens.create') }}">@lang('messages.new')</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Commande No</th>
                                    <th width="10%">@lang('messages.date')</th>
                                    <th width="30%">@lang('Table No')</th>
                                    <th width="30%">@lang('Serveur')</th>
                                    <th width="10%">@lang('messages.status')</th>
                                    <th width="30%">@lang('messages.description')</th>
                                    <th width="10%">@lang('messages.created_by')</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($orders as $order)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td><a href="{{ route('admin.order_kitchens.show',$order->commande_no) }}">{{ $order->commande_no }}</a></td>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $order->table_no }}</td>
                                    <td>{{ $order->employe->name }}</td>
                                    @if($order->status == 1)
                                    <td><span  class="alert alert-success">Validée</span></td>
                                    @elseif($order->status == -1)
                                    <td><span class="alert alert-danger">Rejetée</span></td>
                                    @else
                                    <td><span class="alert alert-primary">Encours...</span></td>
                                    @endif
                                    <td>{{ $order->description }}</td>
                                    <td>{{ $order->created_by }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('order_kitchen.create'))
                                        @if($order->status == 1)
                                        <a href="{{ route('admin.order_kitchens.generatepdf',$order->commande_no) }}"><img src="{{ asset('img/ISSh.gif') }}" width="60" title="Télécharger d'abord le document et puis imprimer"></a>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order_kitchen.validate'))
                                        @if($order->status == 0 || $order->status == -1)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.order_kitchens.validate', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('validate-form-{{ $order->commande_no }}').submit();">
                                                Valider
                                            </a>

                                            <form id="validate-form-{{ $order->commande_no }}" action="{{ route('admin.order_kitchens.validate', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order_kitchen.reject'))
                                            @if($order->status == 0)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.order_kitchens.reject', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('reject-form-{{ $order->commande_no }}').submit();">
                                                Rejeter
                                            </a>
                                            @endif
                                            <form id="reject-form-{{ $order->commande_no }}" action="{{ route('admin.order_kitchens.reject', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order_kitchen.reset'))
                                            @if($order->status == -1 || $order->status == 1)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.order_kitchens.reset', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('reset-form-{{ $order->commande_no }}').submit();">
                                                Annuler
                                            </a>
                                            @endif
                                            <form id="reset-form-{{ $order->commande_no }}" action="{{ route('admin.order_kitchens.reset', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @if($order->status == 0)
                                        @if (Auth::guard('admin')->user()->can('order_kitchen.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.order_kitchens.edit', $order->commande_no) }}">@lang('messages.edit')</a>
                                        @endif
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('order_kitchen.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.order_kitchens.destroy', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $order->commande_no }}').submit();">
                                                @lang('messages.delete')
                                            </a>

                                            <form id="delete-form-{{ $order->commande_no }}" action="{{ route('admin.order_kitchens.destroy', $order->commande_no) }}" method="POST" style="display: none;">
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