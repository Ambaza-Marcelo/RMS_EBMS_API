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
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use PDF;
use Excel;
use Mail;
use Validator;
use GuzzleHttp\Client;
use App\Models\FactureRestaurant;
use App\Models\FactureRestaurantDetail;
use App\Models\OrderKitchen;
use App\Models\Article;
use App\Models\Employe;
use App\Models\Report;
use App\Mail\DeleteFactureMail;

class FactureRestaurantController extends Controller
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

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any invoice !');
        }

        $factures = FactureRestaurant::all();
        return view('backend.pages.invoice_kitchen.index',compact('factures'));
    }


    public function create()
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any invoice !');
        }

        $setting = DB::table('settings')->orderBy('created_at','desc')->first();

        $articles =  Article::where('status','RESTAURANT')->orderBy('name','asc')->get();
        $orders =  OrderKitchen::where('status',1)->whereNotIn('commande_no', function($q){
        $q->select('commande_no')->from('facture_restaurants');
        })->orderBy('commande_no','asc')->get();
        $employes =  Employe::orderBy('name','asc')->get();
        return view('backend.pages.invoice_kitchen.create',compact('articles','employes','setting','orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any invoice !');
        }

        $rules = array(
                //'invoice_date' => 'required',
                'tp_type' => 'required',
                'tp_name' => 'required|max:100|min:3',
                'tp_TIN' => 'required|max:30|min:4',
                'tp_trade_number' => 'required|max:20|min:4',
                'tp_phone_number' => 'required|max:20|min:6',
                'tp_address_commune' => 'required|max:50|min:5',
                'tp_address_quartier' => 'required|max:50|min:5',
                'article_id.*'  => 'required',
                'item_quantity.*'  => 'required',
                'item_price.*'  => 'required',
                'item_ct.*'  => 'required',
                'item_tl.*'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $item_quantity = $request->item_quantity;
            $item_price = $request->item_price;
            $item_ct = $request->item_ct;
            $item_tl =$request->item_tl; 

            $employe_id = $request->employe_id;

            $latest = FactureRestaurant::latest()->first();
            if ($latest) {
               $invoice_number = 'FA' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $invoice_number = 'FA' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }
            

            

            $invoice_signature = $request->tp_TIN."/4a2lSNJJtgNAupjHjDSro5mMJ27mhOmFUsRQulcQAHA/".$request->invoice_date."/".$invoice_number;
        for( $count = 0; $count < count($article_id); $count++ )
        {
            $item_price_nvat = ($item_price[$count]*$item_quantity[$count])+$item_ct[$count];
            $vat = $item_price_nvat*$item_ct[$count];
            $item_price_wvat = $item_price_nvat + $vat;
            $item_total_amount = $item_price_wvat + $item_tl[$count]; 
          $data = array(
            'invoice_number'=>$invoice_number,
            'invoice_date'=> $request->invoice_date,
            'tp_type'=>$request->tp_type,
            'tp_name'=>$request->tp_name,
            'tp_TIN'=>$request->tp_TIN,
            'tp_trade_number'=>$request->tp_trade_number,
            'tp_phone_number'=>$request->tp_phone_number,
            'tp_address_province'=>$request->tp_address_province,
            'tp_address_commune'=>$request->tp_address_commune,
            'tp_address_quartier'=>$request->tp_address_quartier,
            'tp_address_avenue'=>$request->tp_address_avenue,
            'tp_address_rue'=>$request->tp_address_rue,
            'vat_taxpayer'=>$request->vat_taxpayer,
            'ct_taxpayer'=>$request->ct_taxpayer,
            'tl_taxpayer'=>$request->tl_taxpayer,
            'tp_fiscal_center'=>$request->tp_fiscal_center,
            'tp_activity_sector'=>$request->tp_activity_sector,
            'tp_legal_form'=>$request->tp_legal_form,
            'payment_type'=>$request->payment_type,
            'customer_name'=>$request->customer_name,
            'customer_TIN'=>$request->customer_TIN,
            'customer_address'=>$request->customer_address,
            'invoice_signature'=> $invoice_signature,
            'commande_no'=>$request->commande_no,
            'invoice_signature_date'=> Carbon::now(),
            'article_id'=>$article_id[$count],
            'item_quantity'=>$item_quantity[$count],
            'item_price'=>$item_price[$count],
            'item_ct'=>$item_ct[$count],
            'item_tl'=>$item_tl[$count],
            'item_price_nvat'=>$item_price_nvat,
            'vat'=>$vat,
            'item_price_wvat'=>$item_price_wvat,
            'item_total_amount'=>$item_total_amount,
            'employe_id'=> $employe_id,
        );
          $data1[] = $data;
      }


        FactureRestaurantDetail::insert($data1);


            //create facture
            $facture = new FactureRestaurant();
            $facture->invoice_date = $request->invoice_date;
            $facture->invoice_number = $invoice_number;
            $facture->invoice_date =  $request->invoice_date;
            $facture->tp_type = $request->tp_type;
            $facture->tp_name = $request->tp_name;
            $facture->tp_TIN = $request->tp_TIN;
            $facture->tp_trade_number = $request->tp_trade_number;
            $facture->tp_phone_number = $request->tp_phone_number;
            $facture->tp_address_province = $request->tp_address_province;
            $facture->tp_address_commune = $request->tp_address_commune;
            $facture->tp_address_quartier = $request->tp_address_quartier;
            $facture->commande_no = $request->commande_no;
            $facture->vat_taxpayer = $request->vat_taxpayer;
            $facture->ct_taxpayer = $request->ct_taxpayer;
            $facture->tl_taxpayer = $request->tl_taxpayer;
            $facture->tp_fiscal_center = $request->tp_fiscal_center;
            $facture->tp_activity_sector = $request->tp_activity_sector;
            $facture->tp_legal_form = $request->tp_legal_form;
            $facture->payment_type = $request->payment_type;
            $facture->customer_name = $request->customer_name;
            $facture->customer_TIN = $request->customer_TIN;
            $facture->customer_address = $request->customer_address;
            $facture->invoice_signature = $invoice_signature;
            $facture->employe_id = $employe_id;
            $facture->invoice_signature_date = Carbon::now();
            $facture->save();
            session()->flash('success', 'Le vente est fait avec succés!!');
            return redirect()->route('admin.invoice-kitchens.index');
            return back();
    }

    public function validerFacture($invoice_number)
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any invoice !');
        }

        $datas = FactureRestaurantDetail::where('invoice_number', $invoice_number)->get();

        foreach($datas as $data){
                      
                $reportData = array(
                    'article_id' => $data->article_id,
                    'quantity_sold' => $data->item_quantity,
                    'value_sold' => $data->item_quantity * $data->item_price,
                    'facture_no' => $data->invoice_number,
                    'commande_cuisine_no' => $data->commande_no,
                    'created_by' => $this->user->name,
                    'employe_id' => $data->employe_id,
                    'origine_facture' => 'RESTAURANT',
                    'created_at' => \Carbon\Carbon::now()
                );
                $report[] = $reportData;

        }

        Report::insert($report);

        FactureRestaurant::where('invoice_number', '=', $invoice_number)
                ->update(['etat' => 1]);

        session()->flash('success', 'La Facture  est validée avec succés');
        return back();
    }

    public function annulerFacture($invoice_number)
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any invoice !');
        }

        FactureRestaurant::where('invoice_number', '=', $invoice_number)
                ->update(['etat' => -1]);

        session()->flash('success', 'La Facture  est annulée avec succés');
        return back();
    }

    public function facture($invoice_number)
    {
        if (is_null($this->user) || !$this->user->can('facture.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();

        $datas = FactureRestaurantDetail::where('invoice_number', $invoice_number)->get();
        $facture = FactureRestaurant::where('invoice_number', $invoice_number)->first();
        $totalValue = DB::table('facture_restaurant_details')
            ->where('invoice_number', '=', $invoice_number)
            ->sum('item_total_amount');
        $client = FactureRestaurant::where('invoice_number', $invoice_number)->value('customer_name');
        $date = FactureRestaurant::where('invoice_number', $invoice_number)->value('invoice_date');
       
        $pdf = PDF::loadView('backend.pages.document.facture_cuisine',compact('datas','invoice_number','totalValue','client','setting','date','facture'))->setPaper('a6', 'portrait');

        Storage::put('public/facture_cuisine/'.$invoice_number.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download($invoice_number.'.pdf');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $invoice_number
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_number)
    {
        //
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any invoice !');
        }

        $factureDetails = FactureRestaurantDetail::where('invoice_number',$invoice_number)->get();
        $facture = FactureRestaurant::with('employe')->where('invoice_number',$invoice_number)->first();
        return view('backend.pages.invoice_kitchen.show',compact('facture','factureDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $invoice_number
     * @return \Illuminate\Http\Response
     */

    public function edit($invoice_number)
    {
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();

        $articles =  Article::where('status','RESTAURANT')->orderBy('name','asc')->get();
        $orders =  OrderKitchen::where('status',1)->orderBy('commande_no','asc')->get();
        $factureRestaurant = FactureRestaurant::where('invoice_number',$invoice_number)->first();
        $employes =  Employe::orderBy('name','asc')->get();
        return view('backend.pages.invoice_kitchen.edit',compact('articles','employes','setting','orders','factureRestaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $invoice_number
     * @return \Illuminate\Http\Response
     */
    public function update(Request  $request,$invoice_number)
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any invoice !');
        }

        $rules = array(
                //'invoice_date' => 'required',
                'tp_type' => 'required',
                'tp_name' => 'required|max:100|min:3',
                'tp_TIN' => 'required|max:30|min:4',
                'tp_trade_number' => 'required|max:20|min:4',
                'tp_phone_number' => 'required|max:20|min:6',
                'tp_address_commune' => 'required|max:50|min:5',
                'tp_address_quartier' => 'required|max:50|min:5',
                'article_id.*'  => 'required',
                'item_quantity.*'  => 'required',
                'item_price.*'  => 'required',
                'item_ct.*'  => 'required',
                'item_tl.*'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $item_quantity = $request->item_quantity;
            $item_price = $request->item_price;
            $item_ct = $request->item_ct;
            $item_tl =$request->item_tl; 

            $employe_id = $request->employe_id;

            $latest = FactureRestaurant::latest()->first();
            if ($latest) {
               $invoice_number = 'FA' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $invoice_number = 'FA' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }
            

            

            $invoice_signature = $request->tp_TIN."/4a2lSNJJtgNAupjHjDSro5mMJ27mhOmFUsRQulcQAHA/".$request->invoice_date."/".$invoice_number;
        for( $count = 0; $count < count($article_id); $count++ )
        {
            $item_price_nvat = ($item_price[$count]*$item_quantity[$count])+$item_ct[$count];
            $vat = $item_price_nvat*$item_ct[$count];
            $item_price_wvat = $item_price_nvat + $vat;
            $item_total_amount = $item_price_wvat + $item_tl[$count]; 
          $data = array(
            //'invoice_number'=>$invoice_number,
            'invoice_date'=> $request->invoice_date,
            'tp_type'=>$request->tp_type,
            'tp_name'=>$request->tp_name,
            'tp_TIN'=>$request->tp_TIN,
            'tp_trade_number'=>$request->tp_trade_number,
            'tp_phone_number'=>$request->tp_phone_number,
            'tp_address_province'=>$request->tp_address_province,
            'tp_address_commune'=>$request->tp_address_commune,
            'tp_address_quartier'=>$request->tp_address_quartier,
            'tp_address_avenue'=>$request->tp_address_avenue,
            'tp_address_rue'=>$request->tp_address_rue,
            'vat_taxpayer'=>$request->vat_taxpayer,
            'ct_taxpayer'=>$request->ct_taxpayer,
            'tl_taxpayer'=>$request->tl_taxpayer,
            'tp_fiscal_center'=>$request->tp_fiscal_center,
            'tp_activity_sector'=>$request->tp_activity_sector,
            'tp_legal_form'=>$request->tp_legal_form,
            'payment_type'=>$request->payment_type,
            'customer_name'=>$request->customer_name,
            'customer_TIN'=>$request->customer_TIN,
            'customer_address'=>$request->customer_address,
            //'invoice_signature'=> $invoice_signature,
            'commande_no'=>$request->commande_no,
            //'invoice_signature_date'=> Carbon::now(),
            'article_id'=>$article_id[$count],
            'item_quantity'=>$item_quantity[$count],
            'item_price'=>$item_price[$count],
            'item_ct'=>$item_ct[$count],
            'item_tl'=>$item_tl[$count],
            'item_price_nvat'=>$item_price_nvat,
            'vat'=>$vat,
            'item_price_wvat'=>$item_price_wvat,
            'item_total_amount'=>$item_total_amount,
            'employe_id'=> $employe_id,
        );
          FactureRestaurantDetail::where('article_id', '=', $data->article_id)->where('invoice_number',$invoice_number)
                ->update($data);
      }


            //create facture
            $facture = FactureRestaurant::where('invoice_number',$invoice_number)->first();
            $facture->invoice_date = $request->invoice_date;
            //$facture->invoice_number = $invoice_number;
            $facture->invoice_date =  $request->invoice_date;
            $facture->tp_type = $request->tp_type;
            $facture->tp_name = $request->tp_name;
            $facture->tp_TIN = $request->tp_TIN;
            $facture->tp_trade_number = $request->tp_trade_number;
            $facture->tp_phone_number = $request->tp_phone_number;
            $facture->tp_address_province = $request->tp_address_province;
            $facture->tp_address_commune = $request->tp_address_commune;
            $facture->tp_address_quartier = $request->tp_address_quartier;
            $facture->commande_no = $request->commande_no;
            $facture->vat_taxpayer = $request->vat_taxpayer;
            $facture->ct_taxpayer = $request->ct_taxpayer;
            $facture->tl_taxpayer = $request->tl_taxpayer;
            $facture->tp_fiscal_center = $request->tp_fiscal_center;
            $facture->tp_activity_sector = $request->tp_activity_sector;
            $facture->tp_legal_form = $request->tp_legal_form;
            $facture->payment_type = $request->payment_type;
            $facture->customer_name = $request->customer_name;
            $facture->customer_TIN = $request->customer_TIN;
            $facture->customer_address = $request->customer_address;
            //$facture->invoice_signature = $invoice_signature;
            $facture->employe_id = $employe_id;
            //$facture->invoice_signature_date = Carbon::now();
            $facture->save();
            session()->flash('success', 'Le vente est fait avec succés!!');
            return redirect()->route('admin.invoice-kitchens.index');
            return back();
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $invoice_number
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoice_number)
    {
        if (is_null($this->user) || !$this->user->can('invoice_kitchen.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any invoice !');
        }

        $facture = FactureRestaurant::where('invoice_number',$invoice_number)->first();
        if (!is_null($facture)) {
            $facture->delete();
            FactureRestaurantDetail::where('invoice_number',$invoice_number)->delete();

            $email = 'bgatimatare@gmail.com';
            $auteur = $this->user->name;
            $mailData = [
                    'title' => 'Suppression de facture',
                    'email' => $email,
                    'invoice_number' => $invoice_number,
                    'auteur' => $auteur,
                    ];
         
            Mail::to($email)->send(new DeleteFactureMail($mailData));
        }

        session()->flash('success', 'La facture est supprimée !!');
        return back();
    }
}
