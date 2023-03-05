
@extends('backend.layouts.master')

@section('title')
@lang('messages.reception') - @lang('messages.admin_panel')
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection


@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.reception')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.stockins.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.reception')</span></li>
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
                <div class="card-body bg-success">
                    <h4 class="header-title">@lang('messages.new')</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.receptions.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">@lang('messages.date')</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="receptionist">Receptionniste</label>
                            <input type="text" class="form-control" id="receptionist" name="receptionist" placeholder="Entrer le receptionniste">
                        </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="invoice_no">@lang('messages.invoice_no')</label>
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Entrer numero facture">
                        </div>
                        <div class="form-group">
                            <label for="cammande_no">Commande No</label>
                            <input type="text" class="form-control" id="cammande_no" name="commande_no" value="{{$commande_no}}" readonly="readonly">
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="supplier">@lang('messages.supplier')</label>
                            <select class="form-control" name="supplier" id="supplier">
                                <option disabled="disabled" selected="selected">Merci de choisir</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->name}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                         <table class="table table-bordered" id="dynamicTable">  
                            <tr>
                                <th>@lang('messages.item')</th>
                                <th>@lang('messages.quantity')</th>
                                <th>@lang('messages.unit')</th>
                                <th>@lang('messages.unit_price')</th>
                                <!--
                                <th>Remaining Quantity</th> -->
                                <th>Action</th>
                            </tr>
                            @foreach($datas as $data)
                            <tr>  
                                <td> <select class="form-control" name="article_id[]" id="article_id">
                                <option value="{{ $data->article_id }}" class="form-control">{{ $data->article->name }}/{{ $data->article->specification }}</option>
                                </select></td>  
                                <td><input type="number" name="quantity[]" value="{{ $data->quantity }}" class="form-control" /></td>  
                                <td><input type="text" name="unit[]" value="{{$data->article->unit}}" class="form-control" /></td>
                                <td><input type="number" name="unit_price[]" value="{{$data->article->unit_price}}" class="form-control" step="any" min="0"/></td>

                                <td><button type='button' class='btn btn-danger remove-tr'>@lang('messages.delete')</button></td>  
                            </tr> 
                            @endforeach 
                        </table>
                        <button type="button" name="add" id="add" class="btn btn-primary">@lang('messages.addmore')</button> 
                        <div class="col-lg-12">
                            <label for="description">@lang('messages.description')</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Desccription">
                                
                            </textarea>
                        </div>
                        <div style="margin-top: 15px;margin-left: 15px;">
                            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;

         var markup = "<tr>"+
                      "<td>"+
                         "<select class='form-control' name='article_id[]'"+
                            "<option value='0'>Merci de choisir</option>"+
                             "@foreach($articles as $article)"+
                                 "<option value='{{ $article->id }}'>{{ $article->name }}/{{ $article->code }}</option>"+
                             "@endforeach>"+
                          "</select>"+
                        "</td>"+
                        "<td>"+
                          "<input type='number' name='quantity[]' placeholder='Enter Quantity' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<select class='form-control' name='unit[]' id='unit'>"+
                                "<option disabled='disabled' selected='selected'>Merci de choisir</option>"+
                                "<option value='pieces' class='form-control'>Pieces</option>"+
                                "</select>"+
                        "</td>"+
                        "<td>"+
                        "<input type='number' name='unit_price[]' placeholder='Enter Unit price' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<button type='button' class='btn btn-danger remove-tr'>@lang('messages.delete')</button>"+
                        "</td>"+
                    "</tr>";
   
        $("#dynamicTable").append(markup);
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    }); 

</script>
@endsection
