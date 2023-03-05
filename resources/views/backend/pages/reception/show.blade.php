
@extends('backend.layouts.master')

@section('title')
@lang('details des entrees') - @lang('messages.admin_panel')
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection

@section('admin-content')
<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Details sur bon de reception No : {{ $code }}</h4>
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
                                    <th width="10%">Remaining Q.</th>
                                    <th width="10%">Receptioniste</th>
                                    <th width="10%">@lang('messages.created_by')</th>
                                    <th width="20%">@lang('messages.description')</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($receptions as $reception)
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
                                    <td>{{ $reception->remaining_quantity }}</td>
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