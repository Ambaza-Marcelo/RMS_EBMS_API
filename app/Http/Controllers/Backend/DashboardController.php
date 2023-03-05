<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Employe;
use App\Models\Article;
use App\Models\StockinDetail;
use App\Models\StockoutDetail;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Events\RealTimeMessage;
use App\Models\ReceptionDetail;
use App\Models\FactureDetail;
use App\Models\FactureRestaurantDetail;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }


        $month = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        
        $facture_boisson = [];
        foreach ($month as $key => $value) {
            $facture_boisson[] = FactureDetail::where(\DB::raw("DATE_FORMAT(invoice_date, '%m')"),$value)->sum('item_total_amount');
        }

        $facture_restaurant = [];
        foreach ($month as $key => $value) {
            $facture_restaurant[] = FactureRestaurantDetail::where(\DB::raw("DATE_FORMAT(invoice_date, '%m')"),$value)->sum('item_total_amount');
        }

        $total_roles = count(Role::select('id')->get());
        $total_admins = count(Admin::select('id')->get());
        $total_permissions = count(Permission::select('id')->get());
        $total_suppliers = count(Supplier::select('id')->get());

        $total_article = count(Article::select('id')->get());

        $quantit_seuil =count( Stock::whereColumn('quantity', '<=','threshold_quantity')->get());
        $reception_partielle = count(ReceptionDetail::where('status', 1)->get());
        $remaining_quantity = ReceptionDetail::where('status', 1)->sum('remaining_quantity');

        return view('backend.pages.dashboard.index', 
            compact(
            'total_admins', 
            'total_roles', 
            'total_permissions',
            'total_article',
            'total_suppliers',
            'quantit_seuil',
            'reception_partielle',
            'remaining_quantity'

            ))->with('month',json_encode($month,JSON_NUMERIC_CHECK))->with('facture_boisson',json_encode($facture_boisson,JSON_NUMERIC_CHECK))->with('facture_restaurant',json_encode($facture_restaurant,JSON_NUMERIC_CHECK));
    }

    public function changeLang(Request $request){
        \App::setlocale($request->lang);
        session()->put("locale",$request->lang);
        event(new RealTimeMessage('Hello World'));

        return redirect()->back();
    }
}
