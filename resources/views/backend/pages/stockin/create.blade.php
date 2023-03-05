
@extends('backend.layouts.master')

@section('title')
@lang('messages.stockin_create') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.stockin_create')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.stockins.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.stockin_create')</span></li>
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
                    <h4 class="header-title">Nouveau Entré</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.stockins.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-6" id="dynamicDiv">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">@lang('messages.date')</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="handingover">Remettant</label>
                            <input type="text" class="form-control" id="handingover" name="handingover" placeholder="Entrer le nom du remettant">
                        </div>
                        </div>
                        <div class="col-sm-6" id="dynamicInvoice">
                        <div class="form-group">
                            <label for="origin">@lang('messages.origin')</label>
                            <input type="text" class="form-control" id="origin" name="origin" placeholder="Entrer l'Origine">
                        </div>
                    </div>

                         <table class="table table-bordered" id="dynamicTable">  
                            <tr class="bg-secondary">
                                <th>@lang('messages.item')</th>
                                <th>@lang('messages.quantity')</th>
                                <th>@lang('messages.unit')</th>
                                <th>@lang('messages.unit_price')</th>
                                <th>Action</th>
                            </tr>
                            <tr class="bg-success">  
                                <td> <select class="form-control" name="article_id[]" id="article_id">
                                <option disabled="disabled" selected="selected">merci de choisir</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}" class="form-control">{{ $article->name }}/{{ $article->specification }}</option>
                            @endforeach
                            </select></td>  
                                <td><input type="number" name="quantity[]" placeholder="Enter quantity" class="form-control" /></td>  
                                <td><select class="form-control" name="unit[]" id="unit">
                                <option disabled="disabled" selected="selected">merci de choisir</option>
                                <option value="pieces" class="form-control">Pieces</option>
                                </select></td>
                                <td><input type="number" name="unit_price[]" placeholder="Enter Unit price" class="form-control" /></td>    
                                <td><button type="button" name="add" id="add" class="btn btn-success">@lang('messages.addmore')</button></td>  
                            </tr>  
                        </table> 
                        <div class="col-lg-12">
                            <label for="observation"> @lang('messages.description')</label>
                            <textarea class="form-control" name="observation" id="observation" placeholder="Entrer Observation">
                                
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

         var markup = "<tr class='bg-warning'>"+
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
                                "<option disabled='disabled' selected='selected'>merci de choisir</option>"+
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
