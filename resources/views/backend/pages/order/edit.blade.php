
@extends('backend.layouts.master')

@section('title')
@lang('Commande des Articles') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('Commande des Articles')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('Commande des Articles')</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
         <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Commande des Articles</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.orders.store') }}" method="post" id="dynamic_form">
                        @csrf
                    <div class="row">
                        <div class="col-sm-6" id="dynamicDiv">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">@lang('messages.date')</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="supplier_id">@lang('messages.supplier')</label>
                            <select class="form-control" name="supplier_id">
                                <option disabled="disabled" selected="selected">Merci de choisir Fournisseur</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}/{{ $supplier->phone_no }}</option>
                            @endforeach
                            </select>
                        </div>
                        </div>

                         <table class="table table-bordered" id="dynamicTable">  
                            <tr class="bg-secondary">
                                <th>@lang('messages.item')</th>
                                <th>@lang('messages.quantity')(stock)</th>
                                <th>@lang('messages.quantity')</th>
                                <th>@lang('messages.unit')(stock)</th>
                                <th>@lang('messages.unit')</th>
                                <th>Action</th>
                            </tr>
                            @foreach($needs as $need)
                            <tr class="bg-warning">  
                                <td><select class="form-control" name="article_id[]" id="article_id">
                                <option disabled="disabled" selected="selected">merci de choisir</option>
                                <option value="{{ $need->article_id }}" class="form-control">{{ $need->article->name }}/{{$need->article->specification }}/{{ $need->article->category->name }}</option>
                                </select></td>  
                                <td><input name="quantity[]" type="number" value="{{$need->quantity}}" class="form-control" readonly="readonly" /></td>
                                <td><input type="number" name="quantity[]" placeholder="Enter quantity" class="form-control" /></td>
                                <td><input type="text" value="{{$need->unit}}" class="form-control" readonly="readonly" /></td>  
                                <td><select class="form-control" name="unit[]" id="unit">
                                <option disabled="disabled" selected="selected">Merci de choisir</option>
                                <option value="pieces" class="form-control">Pieces</option>
                                </select></td>
                                <td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash-o" aria-hidden='false'></i>&nbsp;Supprimer</button></td>     
                            </tr>
                            @endforeach  
                        </table>
                        <button type="button" name="add" id="add" class="btn btn-success">@lang('messages.addmore')</button> 
                        <div class="col-lg-12">
                            <label for="description">@lang('messages.description')</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Description">
                                
                            </textarea>
                        </div>
                        <div style="margin-top: 15px;margin-left: 15px;">
                            <button type="submit" class="btn btn-primary" id="save">@lang('messages.save')</button>
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
                            "<option>merci de choisir</option>"+
                             "@foreach($articles as $article)"+
                                 "<option value='{{ $article->id }}'>{{ $article->name }}/{{ $article->specification }}</option>"+
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
