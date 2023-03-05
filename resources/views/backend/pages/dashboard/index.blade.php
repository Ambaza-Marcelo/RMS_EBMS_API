
@extends('backend.layouts.master')

@section('title')
@lang('messages.dashboard') - @lang('messages.admin_panel')
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.dashboard')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{url('/404/muradutunge/ivyomwasavye-ntibishoboye-kuboneka')}}">@lang('messages.home')</a></li>
                    <li><span>@lang('messages.dashboard')</span></li>
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
    <div class="col-md-2" id="side-navbar">
    </div>
    @if (Auth::guard('admin')->user()->can('report.view'))
    <div class="col-lg-12">
        @if($reception_partielle > 0)
       <a href="{{ route('admin.receptions.index') }}" title="Un article non receptionné totalement"><span style="float: right;"><img src="{{ asset('img/warning3.gif')}}" width="35"></span></a>@endif
        
        <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="500"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    @endif
    </div>
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg3">
                        <a href="{{ route('admin.articles.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_beer-006.svg') }}" width="200">

                                    @lang('Articles')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div><br>
                <div class="card">
                    <div class="seo-fact sbg5">
                        <a href="{{ route('admin.order_drinks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_barista_at0v.svg') }}" width="200">

                                    @lang('Commande Boissons')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div><br>
                <div class="card">
                    <div class="seo-fact sbg8">
                        <a href="{{ route('ebms_api.invoices.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_special_event-001.svg') }}" width="200">

                                    @lang('Vente Boissons')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg4">
                        <a href="{{ route('admin.stock-status.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_beer-006.svg') }}" width="200">

                                    @lang('Stock')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div><br>
                <div class="card">
                    <div class="seo-fact sbg6">
                        <a href="{{ route('admin.order_kitchens.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_eating_together-004.svg') }}" width="200">

                                    @lang('Commande Cuisine')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div><br>
                <div class="card">
                    <div class="seo-fact sbg4">
                        <a href="{{ route('admin.invoice-kitchens.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_breakfast-005.svg') }}" width="200">

                                    @lang('Vente Cuisine')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div><br>
                <div class="card">
                    <div class="seo-fact sbg4">
                        <a href="{{ route('admin.receptions.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <img src="{{ asset('img/undraw_shopping_app_flsj.svg') }}" width="200">

                                    @lang('Achats')</div>
                                <h2>
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
  </div>
  <!-- ambaza marcellin -pink -->
</div>
@if (Auth::guard('admin')->user()->can('report.view'))
<script type="text/javascript">
    var month = <?php echo $month; ?>;
    var facture_boisson = <?php echo $facture_boisson; ?>;
    var facture_restaurant = <?php echo $facture_restaurant; ?>;
    var barChartData = {
        labels: month,
        datasets: [
        {
            label: 'Vente Bar',
            backgroundColor: "blue",
            data: facture_restaurant
        },
        {
            label: 'Vente restaurant',
            backgroundColor: "#077D92",
            data: facture_boisson
        }

        ]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,  
                    text: 'Statistique des ventes bar et restaurant par mois'
                }
            }
        });
    };
</script>
@endif
@endsection