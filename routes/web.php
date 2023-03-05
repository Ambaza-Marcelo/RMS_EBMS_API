<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);


    //ebms_api
    Route::get('ebms_api/getLogin', 'Backend\FactureController@getLogin')->name('ebms_api.getLogin');
    Route::get('ebms_api/invoices/index', 'Backend\FactureController@index')->name('ebms_api.invoices.index');
    Route::get('ebms_api/facture/create', 'Backend\FactureController@create')->name('ebms_api.invoices.create');
    Route::post('ebms_api/store', 'Backend\FactureController@store')->name('ebms_api.store');
    Route::get('ebms_api/facture/{invoice_number}', 'Backend\FactureController@transfer')->name('ebms_api.transfer');
    Route::put('ebms_api/facture/update/{invoice_number}', 'Backend\FactureController@update')->name('ebms_api.update');
    Route::get('ebms_api/facture/edit/{invoice_number}', 'Backend\FactureController@edit')->name('ebms_api.edit');
    Route::delete('ebms_api/facture/destroy/{invoice_number}', 'Backend\FactureController@destroy')->name('ebms_api.destroy');
    Route::put('ambazapp/facture/valider-facture/{invoice_number}','Backend\FactureController@validerFacture')->name('admin.facture.validate');
    Route::put('ambazapp/facture/annuler-facture/{invoice_number}','Backend\FactureController@annulerFacture')->name('admin.facture.reset');
    Route::get('ambazapp/facture/imprimer/{invoice_number}','Backend\FactureController@facture')->name('admin.facture.imprimer');
    Route::get('ambazapp/facture/show/{invoice_number}','Backend\FactureController@show')->name('admin.facture.show');


    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
    
    //change language
    Route::get('/changeLang','Backend\DashboardController@changeLang')->name('changeLang');


    //addresses routes
    Route::get('addresses/index', 'Backend\AddressController@index')->name('admin.addresses.index');
    Route::get('addresses/create', 'Backend\AddressController@create')->name('admin.addresses.create');
    Route::post('addresses/store', 'Backend\AddressController@store')->name('admin.addresses.store');
    Route::get('addresses/edit/{id}', 'Backend\AddressController@edit')->name('admin.addresses.edit');
    Route::put('addresses/update/{id}', 'Backend\AddressController@update')->name('admin.addresses.update');
    Route::delete('addresses/destroy/{id}', 'Backend\AddressController@destroy')->name('admin.addresses.destroy');

    Route::get('employes/index', 'Backend\EmployeController@index')->name('admin.employes.index');
    Route::get('employes/create', 'Backend\EmployeController@create')->name('admin.employes.create');
    Route::post('employes/store', 'Backend\EmployeController@store')->name('admin.employes.store');
    Route::get('employes/edit/{id}', 'Backend\EmployeController@edit')->name('admin.employes.edit');
    Route::put('employes/update/{id}', 'Backend\EmployeController@update')->name('admin.employes.update');
    Route::delete('employes/destroy/{id}', 'Backend\EmployeController@destroy')->name('admin.employes.destroy');

    Route::get('positions/index', 'Backend\PositionController@index')->name('admin.positions.index');
    Route::get('positions/create', 'Backend\PositionController@create')->name('admin.positions.create');
    Route::post('positions/store', 'Backend\PositionController@store')->name('admin.positions.store');
    Route::get('positions/edit/{id}', 'Backend\PositionController@edit')->name('admin.positions.edit');
    Route::put('positions/update/{id}', 'Backend\PositionController@update')->name('admin.positions.update');
    Route::delete('positions/destroy/{id}', 'Backend\PositionController@destroy')->name('admin.positions.destroy');

    //article routes
    Route::get('ambazapp/articles/index', 'Backend\ArticleController@index')->name('admin.articles.index');
    Route::get('ambazapp/articles/create', 'Backend\ArticleController@create')->name('admin.articles.create');
    Route::post('ambazapp/articles/store', 'Backend\ArticleController@store')->name('admin.articles.store');
    Route::get('ambazapp/articles/edit/{id}', 'Backend\ArticleController@edit')->name('admin.articles.edit');
    Route::put('ambazapp/articles/update/{id}', 'Backend\ArticleController@update')->name('admin.articles.update');
    Route::delete('ambazapp/articles/destroy/{id}', 'Backend\ArticleController@destroy')->name('admin.articles.destroy');
    Route::get('ambazapp/articles/show-by-deposit/{id}', 'Backend\ArticleController@showByDeposit')->name('admin.articles.show-by-deposit');
    Route::get('ambazapp/articles/show-by-rayon/{id}', 'Backend\ArticleController@showByRayon')->name('admin.articles.show-by-rayon');
    Route::get('ambazapp/articles/show-by-category/{id}', 'Backend\ArticleController@showByCategory')->name('admin.articles.show-by-category');
    Route::post('ambazapp/admin/articles/importCsv','Backend\ArticleController@uploadArticle')->name('admin.articles.importCsv');

    //stockin routes
    Route::get('ambazapp/stockins/index', 'Backend\StockinController@index')->name('admin.stockins.index');
    Route::get('ambazapp/stockins/create', 'Backend\StockinController@create')->name('admin.stockins.create');
    Route::post('ambazapp/stockins/store', 'Backend\StockinController@store')->name('admin.stockins.store');
    Route::get('ambazapp/stockins/edit/{bon_no}', 'Backend\StockinController@edit')->name('admin.stockins.edit');
    Route::put('ambazapp/stockins/update/{bon_no}', 'Backend\StockinController@update')->name('admin.stockins.update');
    Route::delete('ambazapp/stockins/destroy/{bon_no}', 'Backend\StockinController@destroy')->name('admin.stockins.destroy');
    Route::get('ambazapp/stockins/show/{bon_no}', 'Backend\StockinController@show')->name('admin.stockins.show');

    Route::get('ambazapp/stockin/generatepdf','Backend\StockinController@htmlPdf')->name('admin.stockin.generatepdf');

    Route::get('ambazapp/stockin/generatepdf/{numero}','Backend\StockinController@bon_entree')->name('admin.stockin.bon_entree');

    //stockout routes
    Route::get('ambazapp/stockouts/index', 'Backend\StockoutController@index')->name('admin.stockouts.index');
    Route::get('ambazapp/stockouts/create', 'Backend\StockoutController@create')->name('admin.stockouts.create');
    Route::post('ambazapp/stockouts/store', 'Backend\StockoutController@store')->name('admin.stockouts.store');
    Route::get('ambazapp/stockouts/edit/{bon_no}', 'Backend\StockoutController@edit')->name('admin.stockouts.edit');
    Route::put('ambazapp/stockouts/update/{bon_no}', 'Backend\StockoutController@update')->name('admin.stockouts.update');
    Route::delete('ambazapp/stockouts/destroy/{bon_no}', 'Backend\StockoutController@destroy')->name('admin.stockouts.destroy');

    Route::get('ambazapp/stockout/generatepdf','Backend\StockoutController@htmlPdf')->name('admin.stockout.generatepdf');
    Route::get('ambazapp/stockouts/generatepdf/{bon_no}','Backend\StockoutController@bon_sortie')->name('admin.stockouts.bon_sortie');
    Route::get('ambazapp/stockouts/show/{bon_no}', 'Backend\StockoutController@show')->name('admin.stockouts.show');

    //virtual stock routes
    Route::get('ambazapp/stock-status/index', 'Backend\StockController@index')->name('admin.stock-status.index');
    Route::delete('ambazapp/stocks/destroy/{id}', 'Backend\StockController@destroy')->name('admin.stocks.destroy');
    Route::get('ambazapp/stock-statement_of_needs/need', 'Backend\StockController@need')->name('admin.statement_of_needs.need');
    Route::get('ambazapp/stock-generatepdf/status', 'Backend\StockController@toPdf')->name('admin.stock-status');

    //invoice kitchens routes
    Route::get('ambazapp/invoice-kitchen/index', 'Backend\FactureRestaurantController@index')->name('admin.invoice-kitchens.index');
    Route::get('ambazapp/invoice-kitchen/create', 'Backend\FactureRestaurantController@create')->name('admin.invoice-kitchens.create');
    Route::post('ambazapp/invoice-kitchen/store', 'Backend\FactureRestaurantController@store')->name('admin.invoice-kitchens.store');
    Route::put('ambazapp/invoice-kitchen/update/{invoice_number}', 'Backend\FactureRestaurantController@update')->name('admin.invoice-kitchens.update');
    Route::get('ambazapp/invoice-kitchen/edit/{invoice_number}', 'Backend\FactureRestaurantController@edit')->name('admin.invoice-kitchens.edit');
    Route::delete('ambazapp/invoice-kitchen/destroy/{invoice_number}', 'Backend\FactureRestaurantController@destroy')->name('admin.invoice-kitchens.destroy');
    Route::put('ambazapp/invoice-kitchen/valider-facture/{invoice_number}','Backend\FactureRestaurantController@validerFacture')->name('admin.invoice-kitchens.validate');
    Route::put('ambazapp/invoice-kitchen/annuler-facture/{invoice_number}','Backend\FactureRestaurantController@annulerFacture')->name('admin.invoice-kitchens.reset');
    Route::get('ambazapp/invoice-kitchen/imprimer/{invoice_number}','Backend\FactureRestaurantController@facture')->name('admin.invoice-kitchens.imprimer');
    Route::get('ambazapp/invoice-kitchen/show/{invoice_number}','Backend\FactureRestaurantController@show')->name('admin.invoice-kitchens.show');


    //suppliers routes
    Route::get('ambazapp/suppliers/index', 'Backend\SupplierController@index')->name('admin.suppliers.index');
    Route::get('ambazapp/suppliers/create', 'Backend\SupplierController@create')->name('admin.suppliers.create');
    Route::post('ambazapp/suppliers/store', 'Backend\SupplierController@store')->name('admin.suppliers.store');
    Route::get('ambazapp/suppliers/edit/{id}', 'Backend\SupplierController@edit')->name('admin.suppliers.edit');
    Route::put('ambazapp/suppliers/update/{id}', 'Backend\SupplierController@update')->name('admin.suppliers.update');
    Route::delete('ambazapp/suppliers/destroy/{id}', 'Backend\SupplierController@destroy')->name('admin.suppliers.destroy');

    //reception routes
    Route::get('ambazapp/receptions/index', 'Backend\ReceptionController@index')->name('admin.receptions.index');
    Route::get('ambazapp/receptions/create/{bon_no}', 'Backend\ReceptionController@create')->name('admin.receptions.create');
    Route::post('ambazapp/receptions/store', 'Backend\ReceptionController@store')->name('admin.receptions.store');
    Route::get('ambazapp/receptions/edit/{id}', 'Backend\ReceptionController@edit')->name('admin.receptions.edit');
    Route::put('ambazapp/receptions/update/{id}', 'Backend\ReceptionController@update')->name('admin.receptions.update');
    Route::delete('ambazapp/receptions/destroy/{id}', 'Backend\ReceptionController@destroy')->name('admin.receptions.destroy');
    Route::get('ambazapp/receptions/show/{bon_no}','Backend\ReceptionController@show')->name('admin.receptions.show');

    Route::get('ambazapp/receptions/bon_reception/{reception_no}','Backend\ReceptionController@bon_reception')->name('admin.receptions.bon_reception');
    Route::put('ambazapp/receptions/validate/{reception_no}', 'Backend\ReceptionController@validateReception')->name('admin.receptions.validate');
    Route::put('ambazapp/receptions/reject/{reception_no}','Backend\ReceptionController@reject')->name('admin.receptions.reject');
    Route::put('ambazapp/receptions/reset/{reception_no}','Backend\ReceptionController@reset')->name('admin.receptions.reset');
    Route::put('ambazapp/receptions/confirm/{reception_no}','Backend\ReceptionController@confirm')->name('admin.receptions.confirm');
    Route::put('ambazapp/receptions/approuve/{reception_no}','Backend\ReceptionController@approuve')->name('admin.receptions.approuve');
    Route::put('ambazapp/receptions/reception/{reception_no}','Backend\ReceptionController@reception')->name('admin.receptions.reception');

    //orders routes
    Route::get('ambazapp/orders/index', 'Backend\OrderController@index')->name('admin.orders.index');
    Route::get('ambazapp/orders/create', 'Backend\OrderController@create')->name('admin.orders.create');
    Route::post('ambazapp/orders/store', 'Backend\OrderController@store')->name('admin.orders.store');
    Route::get('ambazapp/orders/edit/{commande_no}', 'Backend\OrderController@edit')->name('admin.orders.edit');
    Route::put('ambazapp/orders/update/{commande_no}', 'Backend\OrderController@update')->name('admin.orders.update');
    Route::delete('ambazapp/supplier_requisitions/destroy/{commande_no}', 'Backend\OrderController@destroy')->name('admin.orders.destroy');

    Route::get('ambazapp/orders/show/{commande_no}', 'Backend\OrderController@show')->name('admin.orders.show');

    Route::get('ambazapp/orders/generatepdf/{commande_no}','Backend\OrderController@htmlPdf')->name('admin.orders.generatepdf');
    Route::put('ambazapp/orders/validate/{commande_no}', 'Backend\OrderController@validateCommand')->name('admin.orders.validate');
    Route::put('ambazapp/orders/reject/{commande_no}','Backend\OrderController@reject')->name('admin.orders.reject');
    Route::put('ambazapp/orders/reset/{commande_no}','Backend\OrderController@reset')->name('admin.orders.reset');
    Route::put('ambazapp/orders/confirm/{commande_no}','Backend\OrderController@confirm')->name('admin.orders.confirm');
    Route::put('ambazapp/orders/approuve/{commande_no}','Backend\OrderController@approuve')->name('admin.orders.approuve');
    Route::put('ambazapp/orders/reception/{commande_no}','Backend\OrderController@reception')->name('admin.orders.reception');

    //order-kitchen routes
    Route::get('ambazapp/order-kitchen/index', 'Backend\OrderKitchenController@index')->name('admin.order_kitchens.index');
    Route::get('ambazapp/order-kitchen/create', 'Backend\OrderKitchenController@create')->name('admin.order_kitchens.create');
    Route::post('ambazapp/order-kitchen/store', 'Backend\OrderKitchenController@store')->name('admin.order_kitchens.store');
    Route::get('ambazapp/order-kitchen/edit/{commande_no}', 'Backend\OrderKitchenController@edit')->name('admin.order_kitchens.edit');
    Route::put('ambazapp/order-kitchen/update/{commande_no}', 'Backend\OrderKitchenController@update')->name('admin.order_kitchens.update');
    Route::delete('ambazapp/order-kitchen/destroy/{commande_no}', 'Backend\OrderKitchenController@destroy')->name('admin.order_kitchens.destroy');

    Route::get('ambazapp/order-kitchen/show/{commande_no}', 'Backend\OrderKitchenController@show')->name('admin.order_kitchens.show');

    Route::get('ambazapp/order-kitchen/generatepdf/{commande_no}','Backend\OrderKitchenController@htmlPdf')->name('admin.order_kitchens.generatepdf');
    Route::put('ambazapp/order-kitchen/validate/{commande_no}', 'Backend\OrderKitchenController@validateCommand')->name('admin.order_kitchens.validate');
    Route::put('ambazapp/order-kitchen/reject/{commande_no}','Backend\OrderKitchenController@reject')->name('admin.order_kitchens.reject');
    Route::put('ambazapp/order-kitchen/reset/{commande_no}','Backend\OrderKitchenController@reset')->name('admin.order_kitchens.reset');

    //order-drink routes
    Route::get('ambazapp/order-drink/index', 'Backend\OrderDrinkController@index')->name('admin.order_drinks.index');
    Route::get('ambazapp/order-drink/create', 'Backend\OrderDrinkController@create')->name('admin.order_drinks.create');
    Route::post('ambazapp/order-drink/store', 'Backend\OrderDrinkController@store')->name('admin.order_drinks.store');
    Route::get('ambazapp/order-drink/edit/{commande_no}', 'Backend\OrderDrinkController@edit')->name('admin.order_drinks.edit');
    Route::put('ambazapp/order-drink/update/{commande_no}', 'Backend\OrderDrinkController@update')->name('admin.order_drinks.update');
    Route::delete('ambazapp/order-drink/destroy/{commande_no}', 'Backend\OrderDrinkController@destroy')->name('admin.order_drinks.destroy');

    Route::get('ambazapp/order-drink/show/{commande_no}', 'Backend\OrderDrinkController@show')->name('admin.order_drinks.show');

    Route::get('ambazapp/order-drink/generatepdf/{commande_no}','Backend\OrderDrinkController@htmlPdf')->name('admin.order_drinks.generatepdf');
    Route::put('ambazapp/order-drink/validate/{commande_no}', 'Backend\OrderDrinkController@validateCommand')->name('admin.order_drinks.validate');
    Route::put('ambazapp/order-drink/reject/{commande_no}','Backend\OrderDrinkController@reject')->name('admin.order_drinks.reject');
    Route::put('ambazapp/order-drink/reset/{commande_no}','Backend\OrderDrinkController@reset')->name('admin.order_drinks.reset');


     Route::get('ambazapp/categories/index', 'Backend\CategoryController@index')->name('admin.categories.index');
    Route::get('ambazapp/categories/create', 'Backend\CategoryController@create')->name('admin.categories.create');
    Route::post('ambazapp/categories/store', 'Backend\CategoryController@store')->name('admin.categories.store');
    Route::get('ambazapp/categories/edit/{id}', 'Backend\CategoryController@edit')->name('admin.categories.edit');
    Route::put('ambazapp/categories/update/{id}', 'Backend\CategoryController@update')->name('admin.categories.update');
    Route::delete('ambazapp/categories/destroy/{id}', 'Backend\CategoryController@destroy')->name('admin.categories.destroy');

    

    //
    Route::get('ambazapp/inventories/index', 'Backend\InventoryController@index')->name('admin.inventories.index');
    Route::get('ambazapp/inventories/create', 'Backend\InventoryController@create')->name('admin.inventories.create');
    Route::post('ambazapp/inventories/store', 'Backend\InventoryController@store')->name('admin.inventories.store');
    Route::get('ambazapp/inventories/inventory/{id}', 'Backend\InventoryController@inventory')->name('admin.inventories.inventory');
    Route::get('ambazapp/inventories/edit/{inventory_no}', 'Backend\InventoryController@edit')->name('admin.inventories.edit');
    Route::get('ambazapp/inventories/show/{inventory_no}', 'Backend\InventoryController@show')->name('admin.inventories.show');
    Route::put('ambazapp/inventories/update/{id}', 'Backend\InventoryController@update')->name('admin.inventories.update');
    Route::delete('ambazapp/inventories/destroy/{id}', 'Backend\InventoryController@destroy')->name('admin.inventories.destroy');

    Route::get('ambazapp/inventories/generatePdf/{inventory_no}','Backend\InventoryController@bon_inventaire')->name('admin.inventories.generatePdf');
    Route::put('ambazapp/inventories/validate/{inventory_no}','Backend\InventoryController@validateInventory')->name('admin.inventories.validate');
    Route::put('ambazapp/inventories/reject/{inventory_no}','Backend\InventoryController@rejectInventory')->name('admin.inventories.reject');
    Route::put('ambazapp/inventories/reset/{inventory_no}','Backend\InventoryController@resetInventory')->name('admin.inventories.reset');

    //Reports routes
    Route::get('ambazapp/report/stock/day','Backend\ReportController@dayReport')->name('admin.report.stock.day');
    Route::get('ambazapp/report/stock/month','Backend\ReportController@monthReport')->name('admin.report.stock.month');

    Route::get('ambazapp/stock/movement','Backend\ReportController@stockMovement')->name('admin.stock.movement');
    Route::get('ambazapp/stock/movement/generatepdf','Backend\ReportController@stockMovementToPdf')->name('admin.stock.movement.pdf');
    Route::get('ambazapp/report/stock/month/pdf','Backend\ReportController@monthReportToPdf')->name('admin.report.stock.month.pdf');
    Route::get('ambazapp/stock/movement/export','Backend\ReportController@stockMovementExport')->name('admin.stock.movement.export');


    Route::get('ambazapp/journal-vente-boisson/index','Backend\ReportController@journalVente')->name('admin.journalVente.index');
    Route::get('ambazapp/journal-vente-cuisine/index','Backend\ReportController@journalVenteCuisine')->name('admin.journalVenteCuisine.index');
    Route::get('ambazapp/journal-entree/index','Backend\ReportController@journalEntree')->name('admin.journalEntree.index');
    Route::get('ambazapp/journal-reception/index','Backend\ReportController@journalReception')->name('admin.journalReception.index');
    Route::get('ambazapp/journal-sortie/index','Backend\ReportController@journalSortie')->name('admin.journalSortie.index');


    Route::get('ambazapp/journal-vente-boisson/export','Backend\ReportController@journalVenteExport')->name('admin.journalVente.export');
    Route::get('ambazapp/journal-vente-cuisine/export','Backend\ReportController@journalVenteCuisineExport')->name('admin.journalVenteCuisine.export');
    Route::get('ambazapp/journal-entree/export','Backend\ReportController@journalEntreeExport')->name('admin.journalEntree.export');
    Route::get('ambazapp/journal-reception/export','Backend\ReportController@journalReceptionExport')->name('admin.journalReception.export');
    Route::get('ambazapp/journal-sortie/export','Backend\ReportController@journalSortieExport')->name('admin.journalSortie.export');


    Route::get('ambazapp/reference/inventaire','Backend\InventoryController@referenceInventaire')->name('admin.reference-inventaire');


    //settings routes
    Route::get('ambazapp/settings/index', 'Backend\SettingController@index')->name('admin.settings.index');
    Route::get('ambazapp/settings/create', 'Backend\SettingController@create')->name('admin.settings.create');
    Route::post('ambazapp/settings/store', 'Backend\SettingController@store')->name('admin.settings.store');
    Route::get('ambazapp/settings/edit/{id}', 'Backend\SettingController@edit')->name('admin.settings.edit');
    Route::put('ambazapp/settings/update/{id}', 'Backend\SettingController@update')->name('admin.settings.update');
    Route::delete('ambazapp/settings/destroy/{id}', 'Backend\SettingController@destroy')->name('admin.settings.destroy');
    

    //Export routes
    Route::get('ambazapp/article/export','Backend\ArticleController@get_article_data')->name('admin.article.export');
    Route::get('ambazapp/machine/export','Backend\MachineController@get_machine_data')->name('admin.machine.export');
    Route::get('ambazapp/stock/export','Backend\StockController@get_stock_data')->name('admin.stock.export');
    Route::get('ambazapp/stockin/export','Backend\StockinController@get_stockin_data')->name('admin.stockin.export');
    Route::get('ambazapp/stockout/export','Backend\StockoutController@get_stockout_data')->name('admin.stockout.export');


    Route::get('ambazapp/inventory/export','Backend\InventoryController@get_inventory_data')->name('admin.inventory.export');
    Route::get('ambazapp/reception/export','Backend\ReceptionController@get_reception_data')->name('admin.reception.export');
    Route::get('ambazapp/report/export','Backend\ReportController@get_report_data')->name('admin.report.export');
    Route::get('ambazapp/supplier/export','Backend\SupplierController@get_supplier_data')->name('admin.supplier.export');
    Route::get('/404/muradutunge/ivyomwasavye-ntibishoboye-kuboneka',function(){
        return view('errors.404');


    });
});
