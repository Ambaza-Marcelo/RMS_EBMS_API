<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use App\Models\Stockin;
use App\Models\Stock;
use App\Models\RealStock;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Setting;
use PDF;
use Validator;
use App\Exports\InventoryExport;
use Excel;

class InventoryController extends Controller
{
    //
     public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('inventory.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any inventory !');
        }

        $inventories = Inventory::all();

        $year = ['2022','2023','2024','2025','2026','2027','2028','2029','2030','2031','2032','2033','2034','2035','2036','2037','2038','2039','2040','2041','2042','2043','2044','2045'];

        $inventory = [];
        foreach ($year as $key => $value) {
            $inventory[] = InventoryDetail::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->sum('total_value');
        }
        return view('backend.pages.inventory.index', compact('inventories'))->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('inventory',json_encode($inventory,JSON_NUMERIC_CHECK));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('inventory.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any inventory !');
        }

        $articles  = Article::all();
        $datas = Stock::where('verified',false)->get();
        return view('backend.pages.inventory.create', compact('datas','articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('inventory.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any inventory !');
        }
        $rules = array(
            'article_id.*' => 'required',
            'date' => 'required|date',
            //'title' => 'required',
            'quantity.*' => 'required',
            'unit.*' => 'required',
            //'inventory_no' => 'required',
            'unit_price.*' => 'required',
            'new_quantity.*' => 'required',
            'new_price.*' => 'required',
            'description' => 'required',
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $date = $request->date;
            $unit = $request->unit;
            $quantity = $request->quantity;
            $unit_price = $request->unit_price;
            $new_quantity = $request->new_quantity;
            $new_price = $request->new_price;
            $title = $request->title;  
            $inventory_no = "BI000".date("y").substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
            $created_by = $this->user->name;
            $description =$request->description; 

            for( $count = 0; $count < count($article_id); $count++ ){
                $total_value = $quantity[$count] * $unit_price[$count];
                $new_total_value = $new_quantity[$count] * $new_price[$count];
                $relica = $quantity[$count] - $new_quantity[$count];
                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'title' => $title,
                    'quantity' => $quantity[$count],
                    'unit' => $unit[$count],
                    'unit_price' => $unit_price[$count],
                    'total_value' => $total_value,
                    'new_quantity' => $new_quantity[$count],
                    'new_price' => $new_price[$count],
                    'new_total_value' => $new_total_value,
                    'relica' => $relica,
                    'inventory_no' => $inventory_no,
                    'created_by' => $created_by,
                    'description' => $description,
                    'created_at' => \Carbon\Carbon::now()
                );
                $insert_data[] = $data;

                /*
                $valeurStockInitial = Stock::where('article_id', $article_id[$count])->value('total_value');
                //$quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');
                /*
                $valeurAcquisition = $new_quantity[$count] * $new_price[$count];

                $valeurTotalUnite = $new_quantity[$count] + $quantity[$count];
                $cump = ($valeurStockInitial + $valeurAcquisition) / $valeurTotalUnite;

                $calcul_cump = array(
                        'unit_price' => $new_price[$count],
                        'quantity' => $new_quantity[$count]
                    );
                */
                    /*
                $article_calc = array(
                        'unit_price' => $new_price[$count],
                        'quantity' => $new_quantity[$count]
                    );
                Article::where('id',$article_id[$count])
                        ->update($article_calc);

                    $sto = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $new_quantity[$count],
                        'total_value' => $new_price[$count] * $new_quantity[$count],
                        'unit' => $unit[$count],
                        'created_by' => $this->user->name,
                    );

                    Stock::where('article_id',$article_id[$count])
                        ->update($sto);
                    Stock::where('article_id', '=', $article_id[$count])
                ->update(['verified' => true]);
                */
                
            }
            InventoryDetail::insert($insert_data);
            //create inventory
            $inventory = new Inventory();
            $inventory->date = $date;
            $inventory->title = $title;
            $inventory->inventory_no = $inventory_no;
            $inventory->description = $description;
            $inventory->created_by = $created_by;
            $inventory->save();
         
        session()->flash('success', 'Inventory has been created !!');
        return redirect()->route('admin.inventories.index');
    }

    public function referenceInventaire()
    {
        if (is_null($this->user) || !$this->user->can('inventory.view')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $datas = Stock::where('verified',false)->get();
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $pdf = PDF::loadView('backend.pages.document.reference_inventaire',compact('datas','setting'));
        return $pdf->download('reference-inventaire'.'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $inventory_no
     * @return \Illuminate\Http\Response
     */
    public function show($inventory_no)
    {
        //
        $code = InventoryDetail::where('inventory_no', $inventory_no)->value('inventory_no');
        $inventories = InventoryDetail::where('inventory_no', $inventory_no)->get();
        return view('backend.pages.inventory.show', compact('inventories','code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inventory($id)
    {
        if (is_null($this->user) || !$this->user->can('inventory.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to make any inventory !');
        }

        $stock = Stock::find($id);
        $articles  = Article::all();
        return view('backend.pages.inventory.create', compact('stock', 'articles'));
    }

    public function edit($inventory_no)
    {
        if (is_null($this->user) || !$this->user->can('inventory.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any inventory !');
        }

        $inventory_no  = InventoryDetail::where('inventory_no', $inventory_no)->value('inventory_no');
        $inventory = Inventory::where('inventory_no', $inventory_no)->first();
        $datas = InventoryDetail::where('inventory_no', $inventory_no)->get();
        //
        //$stock = Stock::where('article_id', '=', $id)->first();
        return view('backend.pages.inventory.edit', compact('inventory', 'inventory_no','datas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $inventory_no)
    {
        if (is_null($this->user) || !$this->user->can('inventory.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any inventory !');
        }

        $rules = array(
            'article_id.*' => 'required',
            'date' => 'required|date',
            'quantity.*' => 'required',
            'unit.*' => 'required',
            'unit_price.*' => 'required',
            'new_quantity.*' => 'required',
            'new_price.*' => 'required',
            'description' => 'required',
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $date = $request->date;
            $unit = $request->unit;
            $quantity = $request->quantity;
            $unit_price = $request->unit_price;
            $new_quantity = $request->new_quantity;
            $new_price = $request->new_price;
            $title = $request->title;  

            $created_by = $this->user->name;
            $description =$request->description; 

            for( $count = 0; $count < count($article_id); $count++ ){
                $total_value = $quantity[$count] * $unit_price[$count];
                $new_total_value = $new_quantity[$count] * $new_price[$count];
                $relica = $quantity[$count] - $new_quantity[$count];
                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'title' => $title,
                    'quantity' => $quantity[$count],
                    'unit' => $unit[$count],
                    'unit_price' => $unit_price[$count],
                    'total_value' => $total_value,
                    'new_quantity' => $new_quantity[$count],
                    'new_price' => $new_price[$count],
                    'new_total_value' => $new_total_value,
                    'relica' => $relica,
                    'created_by' => $created_by,
                    'description' => $description,
                    'created_at' => \Carbon\Carbon::now()
                );
                $insert_data[] = $data;

                /*

                $valeurStockInitial = Stock::where('article_id', $article_id[$count])->value('total_value');*/
                //$quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');
                /*

                $valeurAcquisition = $new_quantity[$count] * $new_price[$count];

                $valeurTotalUnite = $new_quantity[$count] + $quantity[$count];
                $cump = ($valeurStockInitial + $valeurAcquisition) / $valeurTotalUnite;

                $calcul_cump = array(
                        'unit_price' => $cump,
                        'quantity' => $new_quantity[$count]
                    );
                */
                    /*
                $article_calc = array(
                        'unit_price' => $new_price[$count],
                        'quantity' => $new_quantity[$count]
                    );

                Article::where('id',$article_id[$count])
                        ->update($calcul_cump);

                    $sto = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $new_quantity[$count],
                        'total_value' => $cump * $new_quantity[$count],
                        'unit' => $unit[$count],
                        'created_by' => $this->user->name,
                    );

                    Stock::where('article_id',$article_id[$count])
                        ->update($sto);
                    Stock::where('article_id', '=', $article_id[$count])
                ->update(['verified' => true]);
                InventoryDetail::where('inventory_no', $inventory_no)->where('article_id',$article_id[$count])
                        ->update($data);
                        */
                
            }
            
            //create inventory
            $inventory = Inventory::where('inventory_no', $inventory_no)->first();
            $inventory->date = $date;
            $inventory->title = $title;
            $inventory->description = $description;
            $inventory->created_by = $created_by;
            $inventory->save();

        session()->flash('success', 'Inventory has been updated !!');
        return back();
    }

    public function bon_inventaire($inventory_no)
    {
        if (is_null($this->user) || !$this->user->can('inventory.view')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $description = Inventory::where('inventory_no', $inventory_no)->value('description');
        $title = Inventory::where('inventory_no', $inventory_no)->value('title');
        $code = Inventory::where('inventory_no', $inventory_no)->value('inventory_no');
        $date = Inventory::where('inventory_no', $inventory_no)->value('date');
        $datas = InventoryDetail::where('inventory_no', $inventory_no)->get();
        //$totalValueActuelle = Inventory::where('inventory_no','=',$inventory_no)->sum('total_value')->get();
        $totalValueActuelle = DB::table('inventory_details')
            ->where('inventory_no', '=', $inventory_no)
            ->sum('total_value');
         $totalValueNew = DB::table('inventory_details')
            ->where('inventory_no', '=', $inventory_no)
            ->sum('new_total_value');
        $gestionnaire = Inventory::where('inventory_no', $inventory_no)->value('created_by');
        $pdf = PDF::loadView('backend.pages.document.bon_inventaire',compact('datas','code','totalValueActuelle','totalValueNew','gestionnaire','setting','title','description','date'));//->setPaper('a4', 'landscape');

        Storage::put('public/pdf/bon_inventaire/'.$inventory_no.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download($inventory_no.'.pdf');
    }

    public function get_inventory_data()
    {
        return Excel::download(new InventoryExport, 'inventories.xlsx');
    }


    public function validateInventory($inventory_no)
    {
       if (is_null($this->user) || !$this->user->can('inventory.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any inventory !');
        }

        $datas = InventoryDetail::where('inventory_no', $inventory_no)->get();

        foreach($datas as $data){
            $valeurStockInitial = Stock::where('article_id', $data->article_id)->value('total_value');
                //$quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');
                /*

                $valeurAcquisition = $new_quantity[$count] * $new_price[$count];

                $valeurTotalUnite = $new_quantity[$count] + $quantity[$count];
                $cump = ($valeurStockInitial + $valeurAcquisition) / $valeurTotalUnite;

                $calcul_cump = array(
                        'unit_price' => $cump,
                        'quantity' => $new_quantity[$count]
                    );
                */

                $article_calc = array(
                        'unit_price' => $data->new_price,
                        'quantity' => $data->new_quantity
                    );


                Article::where('id',$data->article_id)
                        ->update($article_calc);

                    $sto = array(
                        'article_id' => $data->article_id,
                        'quantity' => $data->new_quantity,
                        'total_value' => $data->new_price * $data->new_quantity,
                        'unit' => $data->unit,
                        'created_by' => $this->user->name,
                    );

                    Stock::where('article_id',$data->article_id)
                        ->update($sto);
                    Stock::where('article_id', '=', $data->article_id)
                ->update(['verified' => true]);
        }
            Inventory::where('inventory_no', '=', $inventory_no)
                ->update(['status' => 2]);

        session()->flash('success', 'inventory has been validated !!');
        return back();
    }

    public function rejectInventory($inventory_no)
    {
       if (is_null($this->user) || !$this->user->can('inventory.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any inventory !');
        }
            Inventory::where('inventory_no', '=', $inventory_no)
                ->update(['status' => 1]);

        session()->flash('success', 'inventory has been rejected !!');
        return back();
    }

    public function resetInventory($inventory_no)
    {
       if (is_null($this->user) || !$this->user->can('inventory.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any inventory !');
        }
            Inventory::where('inventory_no', '=', $inventory_no)
                ->update(['status' => 0]);

        session()->flash('success', 'inventory has been reseted !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($inventory_no)
    {
        if (is_null($this->user) || !$this->user->can('inventory.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any inventory !');
        }

        $inventory = Inventory::where('inventory_no', $inventory_no)->first();
        if (!is_null($inventory)) {
            $inventory->delete();
            InventoryDetail::where('inventory_no',$inventory_no)->delete();
        }

        session()->flash('success', 'Inventory has been deleted !!');
        return back();
    }
}
