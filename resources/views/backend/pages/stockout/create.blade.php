
@extends('backend.layouts.master')

@section('title')
@lang('messages.stockout_create') - @lang('messages.admin_panel')
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.stockout_create')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.stockouts.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.stockout_create')</span></li>
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
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body bg-success">
                    <h4 class="header-title">@lang('messages.stockout_create')</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.stockouts.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="date">@lang('messages.date')</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="asker">@lang('messages.asker')</label>
                            <input type="asker" class="form-control" id="asker" name="asker" placeholder="Entrer nom du demandeur">
                        </div>
                        </div>


                    </div>

                         <table class="table table-bordered" id="dynamicTable">  
                            <tr class="bg-secondary">
                                <th>@lang('messages.item')</th>
                                <th>@lang('messages.quantity')</th>
                                <th>@lang('messages.unit')</th>
                                <th>Destination</th>
                                <th>Action</th>
                            </tr>
                            <tr class="">  
                                <td> <select class="form-control" name="article_id[]" id="article_id">
                                <option disabled="disabled" selected="selected">Merci de choisir</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}" class="form-control">{{ $article->name }}/{{ $article->specification }}/{{ $article->category->name }}</option>
                            @endforeach
                            </select></td>  
                                <td><input type="number" name="quantity[]" placeholder="Enter quantity" class="form-control" /></td>  
                                <td><select class="form-control" name="unit[]" id="unit">
                                <option disabled="disabled" selected="selected">Merci de choisir</option>
                                <option value="pieces" class="form-control">Pieces</option>
                                </select></td>
                                <td><input type="text" class="form-control" name="destination[]" placeholder="Entrer la Destination"></td>   
                                <td><button type="button" name="add" id="add" class="btn btn-primary">@lang('messages.addmore')</button></td>  
                            </tr>  
                        </table> 
                        <div class="col-lg-12">
                            <label for="observation">@lang('messages.description')</label>
                            <textarea class="form-control" name="observation" id="observation" placeholder="Enter Stockin Observation">
                                
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

         var markup = "<tr class=''>"+
                      "<td>"+
                         "<select class='form-control' name='article_id[]'"+
                            "<option value='0'>Merci de choisir</option>"+
                             "@foreach($articles as $article)"+
                                 "<option value='{{ $article->id }}'>{{ $article->name }}/{{ $article->specification }}/{{ $article->category->name }}</option>"+
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
                          "<input type='number' name='destination[]' placeholder='Enter La Destination' class='form-control' />"+
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
