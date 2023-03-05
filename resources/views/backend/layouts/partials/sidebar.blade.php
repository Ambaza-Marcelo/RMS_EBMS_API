 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">AMBAZAPP</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}" aria-expanded="true"><i class="ti-dashboard"></i><span>@lang('messages.dashboard')</span></a>
                    </li>
                    @endif
                    
                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('messages.users')
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('messages.users')</a></li>
                            @endif
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}"><i class="fa fa-tasks"></i> &nbsp;@lang('messages.roles') & @lang('messages.permissions')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('stockin.create') || $usr->can('stockin.view') ||  $usr->can('stockin.edit') ||  $usr->can('stockin.delete') || $usr->can('stockout.create') || $usr->can('stockout.view') ||  $usr->can('stockout.edit') ||  $usr->can('stockout.delete') || $usr->can('article.create') || $usr->can('article.view') ||  $usr->can('article.edit') ||  $usr->can('article.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-basket"></i><span>
                            @lang('messages.stock')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('category.view'))
                                <li class=""><a href="{{ route('admin.categories.index') }}"><i class="fa fa-diamond"></i>&nbsp;@lang('Categorie')</a></li>
                                @endif
                                @if ($usr->can('article.view'))
                                <li class=""><a href="{{ route('admin.articles.index') }}"><i class="fa fa-rebel"></i>&nbsp;@lang('messages.article')</a></li>
                                @endif
                                @if ($usr->can('stockin.view'))
                                <li class=""><a href="{{ route('admin.stockins.index') }}"><i class="fa fa-battery-three-quarters"></i>&nbsp;@lang('messages.stockin')</a></li>
                                @endif
                                @if ($usr->can('stockout.view'))
                                <li class=""><a href="{{ route('admin.stockouts.index') }}"><i class="fa fa-battery-half"></i>&nbsp;@lang('messages.stockout')</a></li>
                                @endif
                                @if ($usr->can('stock.view'))
                                <li class=""><a href="{{ route('admin.stock-status.index') }}"><i class="fa fa-shopping-bag"></i>&nbsp;@lang('messages.virtualstock')</a></li>
                                @endif
                                @if ($usr->can('inventory.view'))
                                <li class=""><a href="{{ route('admin.inventories.index') }}"><i class="fa fa-list"></i>&nbsp;@lang('messages.inventory')</a></li>
                                @endif
                                @if ($usr->can('report.view'))
                                <li class=""><a href="{{ route('admin.stock.movement') }}"><i class="fa fa-shopping-basket"></i>&nbsp;@lang('Journal Général')</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if ( $usr->can('order_kitchen.create') || $usr->can('order_kitchen.view') ||  $usr->can('order_kitchen.edit') ||  $usr->can('order_kitchen.delete') ||  $usr->can('order_drink.view') ||  $usr->can('order_drink.create'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-cart"></i><span>
                            @lang('Commande Client')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('order_drink.view'))
                                <li class=""><a href="{{ route('admin.order_drinks.index') }}">@lang('Commande Boissons')</a></li>
                                @endif
                                @if ($usr->can('order_kitchen.view'))
                                <li class=""><a href="{{ route('admin.order_kitchens.index') }}">@lang('Commande Cuisine')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    @if ( $usr->can('order.create') || $usr->can('order.view') ||  $usr->can('order.edit') ||  $usr->can('order.delete') ||  $usr->can('reception.view') ||  $usr->can('reception.create'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-cart"></i><span>
                            @lang('Achat')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('stock.view'))
                                <li class=""><a href="{{ route('admin.statement_of_needs.need') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Etat des besoins')</a></li>
                                @endif
                                @if ($usr->can('order.view'))
                                <li class=""><a href="{{ route('admin.orders.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('messages.order')</a></li>
                                @endif
                                @if ($usr->can('reception.view'))
                                <li class=""><a href="{{ route('admin.receptions.index') }}"><i class="fa fa-shopping-basket"></i>&nbsp;@lang('Reception')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    <hr>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-cart"></i><span>
                            @lang('Ventes')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('invoice_drink.view'))
                                <li class=""><a href="{{ route('ebms_api.invoices.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Facturation BOISSON')</a></li>
                                @endif
                                @if ($usr->can('invoice_kitchen.view'))
                                <li class=""><a href="{{ route('admin.invoice-kitchens.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Facturation Cuisine')</a></li>
                                @endif
                                @if ($usr->can('invoice_drink.view'))
                                <li class=""><a href="{{ route('ebms_api.getLogin') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('EBMS LOGIN')</a></li>
                                @endif
                    </ul>
                    @if($usr->can('employe.view') || $usr->can('employe.create') || $usr->can('employe.edit') || $usr->can('employe.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-male"></i><span>
                            @lang('Employés')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('employe.view'))
                                <li class=""><a href="{{ route('admin.employes.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Employés')</a></li>
                                @endif
                                @if ($usr->can('employe.view'))
                                <li class=""><a href="{{ route('admin.positions.index') }}"><i class="fa fa-map-marker"></i>&nbsp;@lang('Position')</a></li>
                                @endif
                                @if ($usr->can('employe.view'))
                                <li class=""><a href="{{ route('admin.addresses.index') }}"><i class="fa fa-map-marker"></i>&nbsp;@lang('messages.address')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    <hr>
                    @if($usr->can('supplier.view') || $usr->can('supplier.create') || $usr->can('supplier.edit') || $usr->can('supplier.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-male"></i><span>
                            @lang('messages.suppliers')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('supplier.view'))
                                <li class=""><a href="{{ route('admin.suppliers.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('messages.suppliers')</a></li>
                                @endif
                                @if ($usr->can('address.view'))
                                <li class="{{ Route::is('admin.address.index')  || Route::is('admin.address.edit') ? 'active' : '' }}"><a href="{{ route('admin.addresses.index') }}"><i class="fa fa-map-marker"></i>&nbsp;@lang('messages.address')</a></li>
                            @endif

                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('report.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-bar-chart"></i><span>
                            @lang('Les Journaux')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('report.view'))
                                <li class=""><a href="{{ route('admin.journalVente.index')}}">@lang('Journal Vente Boissons')</a></li>
                                @endif
                                @if ($usr->can('report.view'))
                                <li class=""><a href="{{ route('admin.journalVenteCuisine.index')}}">@lang('Journal Vente Cuisine')</a></li>
                                @endif
                                @if ($usr->can('report.view'))
                                <li class=""><a href="{{ route('admin.journalEntree.index')}}">@lang('Journal des Entrees')</a></li>
                                @endif
                                @if ($usr->can('report.view'))
                                <li class=""><a href="{{ route('admin.journalSortie.index')}}">@lang('Journal des Sorties')</a></li>
                                @endif
                                @if ($usr->can('report.view'))
                                <li class=""><a href="{{ route('admin.journalReception.index')}}">@lang('Journal des receptions')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    
                    <hr>
                    @if($usr->can('setting.view'))
                    <li class=""><a href="{{ route('admin.settings.index') }}"><i class="fa fa-cogs"></i><span>@lang('messages.setting')</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
