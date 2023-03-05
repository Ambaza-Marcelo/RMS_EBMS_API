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
use App\Models\Employe;
use App\Models\OrderDrink;
use App\Models\OrderDrinkDetail;
use App\Models\Article;
use Validator;
use PDF;

class OrderDrinkController extends Controller
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
        if (is_null($this->user) || !$this->user->can('order_drink.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any order !');
        }

        $orders = OrderDrink::all();
        return view('backend.pages.order_drink.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('order_drink.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any order !');
        }

        $articles  = Article::where('status','BOISSON')->orderBy('name','asc')->get();
        $employes  = Employe::all();
        return view('backend.pages.order_drink.create', compact('articles','employes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('order_drink.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any order !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'employe_id'  => 'required',
                'quantity.*'  => 'required',
                'table_no'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $date = $request->date;
            $quantity = $request->quantity;
            $table_no = $request->table_no;
            $employe_id = $request->employe_id;
            $description =$request->description; 
            $auteur = $this->user->name;

            $latest = OrderDrink::latest()->first();
            if ($latest) {
               $commande_no = 'BC' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $commande_no = 'BC' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }

            //create order
            $order = new OrderDrink();
            $order->date = $date;
            $order->commande_no = $commande_no;
            $order->employe_id = $employe_id;
            $order->auteur = $auteur;
            $order->description = $description;
            $order->table_no = $table_no;
            $order->save();
            //insert details of order No.
            for( $count = 0; $count < count($article_id); $count++ ){

                $unit_price = Article::where('id', $article_id[$count])->value('unit_price');
                $total_value = $quantity[$count] * $unit_price;
                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'table_no' => $table_no,
                    'description' => $description,
                    'total_value' => $total_value,
                    'auteur' => $auteur,
                    'commande_no' => $commande_no,
                    'employe_id' => $employe_id,
                );
                $insert_data[] = $data;
            }
            /*
            $mail = Employe::where('id', $employe_id)->value('mail');
            $name = Employe::where('id', $employe_id)->value('name');

            $mailData = [
                    'title' => 'COMMANDE',
                    'commande_no' => $commande_no,
                    'name' => $name,
                    //'body' => 'This is for testing email using smtp.'
                    ];
         
        Mail::to($mail)->send(new OrderMail($mailData));
        */

            OrderDrinkDetail::insert($insert_data);

        session()->flash('success', 'Order has been sent successfuly!!');
        return redirect()->route('admin.order_drinks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bon_no)
    {
        //
         $code = OrderDrink::where('commande_no', $bon_no)->value('commande_no');
         $orderDetails = OrderDrinkDetail::where('commande_no', $bon_no)->get();
         return view('backend.pages.order_drink.show', compact('orderDetails','code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('order_drink.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        $order = OrderDrink::find($id);
        $employes  = Employe::all();
        $articles  = Article::where('status','BOISSON')->orderBy('name','asc')->get();
        return view('backend.pages.order_drink.edit', compact('order','employes','articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('order_drink.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        
    }

    public function validateCommand($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order_drink.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any order !');
        }
            OrderDrink::where('commande_no', '=', $commande_no)
                ->update(['status' => 1]);

        session()->flash('success', 'order has been validated !!');
        return back();
    }

    public function reject($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order_drink.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any order !');
        }

        OrderDrink::where('commande_no', '=', $commande_no)
                ->update(['status' => -1]);

        session()->flash('success', 'Order has been rejected !!');
        return back();
    }

    public function reset($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order_drink.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any order !');
        }

        OrderDrink::where('commande_no', '=', $commande_no)
                ->update(['status' => -2]);

        session()->flash('success', 'Order has been reseted !!');
        return back();
    }

    public function htmlPdf($commande_no)
    {
        if (is_null($this->user) || !$this->user->can('order_drink.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $stat = OrderDrink::where('commande_no', $commande_no)->value('status');
        $description = OrderDrink::where('commande_no', $commande_no)->value('description');
        $date = OrderDrink::where('commande_no', $commande_no)->value('date');
        $order = OrderDrink::where('commande_no', $commande_no)->first();
        $totalValue = DB::table('order_drink_details')
            ->where('commande_no', '=', $commande_no)
            ->sum('total_value');

        if($stat == 1){
           $code = OrderDrink::where('commande_no', $commande_no)->value('commande_no');

           $datas = OrderDrinkDetail::where('commande_no', $commande_no)->get();
           $pdf = PDF::loadView('backend.pages.document.order_drink',compact('datas','code','setting','description','date','totalValue','order'))->setPaper('a6', 'portrait');

           Storage::put('public/commande_boisson/'.$commande_no.'.pdf', $pdf->output());

           // download pdf file
           return $pdf->download($commande_no.'.pdf'); 
           
        }else if ($stat == -1) {
            session()->flash('error', 'Order has been rejected !!');
            return back();
        }else{
            session()->flash('error', 'wait until order will be validated !!');
            return back();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($commande_no)
    {
        if (is_null($this->user) || !$this->user->can('order_drink.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any order !');
        }

        $order = OrderDrink::where('commande_no',$commande_no)->first();
        if (!is_null($order)) {
            $order->delete();
            OrderDrinkDetail::where('commande_no',$commande_no)->delete();
        }

        session()->flash('success', 'Order has been deleted !!');
        return back();
    }
}
