
@extends('backend.layouts.master')

@section('title')
@lang('Commande des Articles') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('Commande des Articles')</h4>
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
                    <h4 class="header-title float-left">Commande des Articles</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('order.create'))
                            <a class="btn btn-success text-white" href="" title="Exporter en Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                            <a class="btn btn-primary text-white" href="{{ route('admin.orders.create') }}">@lang('messages.new')</a>
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
                                    <td><a href="{{ route('admin.orders.show',$order->commande_no) }}">{{ $order->commande_no }}</a></td>
                                    <td>{{ $order->date }}</td>
                                    @if($order->status == 2)
                                    <td><span  class="alert alert-success">Validée</span></td>
                                    @elseif($order->status == -1)
                                    <td><span class="alert alert-danger">Rejetée</span></td>
                                    @elseif($order->status == 3)
                                    <td><span class="alert alert-success">confirmée</span></td>
                                    @elseif($order->status == 4)
                                    <td><span class="alert alert-success">Approuvée</span></td>
                                    @elseif($order->status == 5)
                                    <td><span class="alert alert-success">Receptionnée</span></td>
                                    @else
                                    <td><span class="alert alert-primary">Encours...</span></td>
                                    @endif
                                    <td>{{ $order->description }}</td>
                                    <td>{{ $order->created_by }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('bon_commande.create'))
                                        @if($order->status == 2 && $order->status == 3 || $order->status == 4 || $order->status == 5)
                                        <a href="{{ route('admin.orders.generatepdf',$order->commande_no) }}"><img src="{{ asset('img/ISSh.gif') }}" width="60" title="Télécharger d'abord le document et puis imprimer"></a>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order.validate'))
                                        @if($order->status == 1 || $order->status == -1)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.orders.validate', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('validate-form-{{ $order->commande_no }}').submit();">
                                                Valider
                                            </a>

                                            <form id="validate-form-{{ $order->commande_no }}" action="{{ route('admin.orders.validate', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order.confirm'))
                                        @if($order->status == 2)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.orders.confirm', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('confirm-form-{{ $order->commande_no }}').submit();">
                                                Confirmer
                                            </a>

                                            <form id="confirm-form-{{ $order->commande_no }}" action="{{ route('admin.orders.confirm', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order.approuve'))
                                        @if($order->status == 3)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.orders.approuve', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('approuve-form-{{ $order->commande_no }}').submit();">
                                                Approuver
                                            </a>

                                            <form id="approuve-form-{{ $order->commande_no }}" action="{{ route('admin.orders.approuve', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order.reject'))
                                            @if($order->status == 1 || $order->status == 2 || $order->status == 3)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.orders.reject', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('reject-form-{{ $order->commande_no }}').submit();">
                                                Rejeter
                                            </a>
                                            @endif
                                            <form id="reject-form-{{ $order->commande_no }}" action="{{ route('admin.orders.reject', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('order.reset'))
                                            @if($order->status == -1 || $order->status == 2 || $order->status == 3 || $order->status == 4)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.orders.reset', $order->commande_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('reset-form-{{ $order->commande_no }}').submit();">
                                                Annuler
                                            </a>
                                            @endif
                                            <form id="reset-form-{{ $order->commande_no }}" action="{{ route('admin.orders.reset', $order->commande_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('reception.create'))
                                        @if($order->status == 4)
                                        <a href="{{ route('admin.receptions.create',$order->commande_no) }}" class="btn btn-primary">Receptionner</a>
                                        @endif
                                        @endif
                                        @if($order->status == 1)
                                        @if (Auth::guard('admin')->user()->can('order.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.orders.edit', $order->id) }}">@lang('messages.edit')</a>
                                        @endif
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('order.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.orders.destroy', $order->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $order->id }}').submit();">
                                                @lang('messages.delete')
                                            </a>

                                            <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display: none;">
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