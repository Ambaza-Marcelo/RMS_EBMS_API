
@extends('backend.layouts.master')

@section('title')
@lang('messages.articles') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.articles')</h4>
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
                <form action="{{ route('admin.articles.importCsv') }}" method="POST" enctype="multipart/form-data">
                        <p class="float-left mb-2">
                        <input type="file" name="file" class="form-control fa fa-upload" id="articleFile">
                        </p>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-success">Import CSV</button>
                    </form>
                <div class="card-body">
                    <h4 class="header-title float-left">@lang('messages.articles')</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('article.create'))
                            <a class="btn btn-success text-white" href="{{ route('admin.article.export') }}" title="Exporter en Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                            <a class="btn btn-primary text-white" href="{{ route('admin.articles.create') }}">@lang('messages.new')</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">@lang('messages.item')</th>
                                    <th width="10%">@lang('messages.code')</th>
                                    <th width="10%">@lang('messages.specification')</th>
                                    <th width="10%">@lang('messages.quantity')</th>
                                    <th width="10%">@lang('messages.unit')</th>
                                    <th width="10%">@lang('messages.unit_price')</th>
                                    <th width="10%">@lang('messages.category')</th>
                                    <th width="10%">@lang('messages.expiration_date')</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($articles as $article)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $article->name }}</td>
                                    <td>{{ $article->code }}</td>
                                    <td>{{ $article->specification }}</td>
                                    <td>{{ $article->quantity }}</td>
                                    <td>{{ $article->unit }}</td>
                                    <td>{{ number_format($article->unit_price,0,',','.') }}</td>
                                    <td>{{ $article->category->name }}</td>
                                    <td>{{ $article->expiration_date }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('article.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.articles.edit', $article->id) }}">@lang('messages.edit')</a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('article.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.articles.destroy', $article->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $article->id }}').submit();">
                                                @lang('messages.delete')
                                            </a>

                                            <form id="delete-form-{{ $article->id }}" action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display: none;">
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