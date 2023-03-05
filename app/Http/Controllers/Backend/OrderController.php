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
use App\Models\Supplier;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Address;
use App\Models\Article;
use App\Models\Stock;
use Validator;
use PDF;
use Mail;
use App\Mail\OrderMail;
class OrderController extends Controller
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
        if (is_null($this->user) || !$this->user->can('order.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any order !');
        }

        $orders = Order::all();
        return view('backend.pages.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('order.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any order !');
        }

        $articles  = Article::all();
        $needs = Stock::whereColumn('quantity', '<=','threshold_quantity')->get();
        $suppliers  = Supplier::all();
        return view('backend.pages.order.create', compact('articles','suppliers','needs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('order.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any order !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'supplier_id'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'unit.*'  => 'required',
                'description'  => 'required'
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
            $unit = $request->unit;
            $supplier_id = $request->supplier_id;
            $description =$request->description; 
            $commande_no = "BC000".date("y").substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
            $created_by = $this->user->name;

            //create order
            $order = new Order();
            $order->date = $date;
            $order->commande_no = $commande_no;
            $order->supplier_id = $supplier_id;
            $order->created_by = $created_by;
            $order->description = $description;
            $order->save();
            //insert details of order No.
            for( $count = 0; $count < count($article_id); $count++ ){

                $unit_price = Article::where('id', $article_id[$count])->value('unit_price');
                $total_value = $quantity[$count] * $unit_price;
                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'unit' => $unit[$count],
                    'description' => $description,
                    'total_value' => $total_value,
                    'created_by' => $created_by,
                    'commande_no' => $commande_no,
                    'supplier_id' => $supplier_id,
                );
                $insert_data[] = $data;
            }
            /*
            $mail = Supplier::where('id', $supplier_id)->value('mail');
            $name = Supplier::where('id', $supplier_id)->value('name');

            $mailData = [
                    'title' => 'COMMANDE',
                    'commande_no' => $commande_no,
                    'name' => $name,
                    //'body' => 'This is for testing email using smtp.'
                    ];
         
        Mail::to($mail)->send(new OrderMail($mailData));
        */

            OrderDetail::insert($insert_data);

        session()->flash('success', 'Order has been created !!');
        return redirect()->route('admin.orders.index');
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
         $code = Order::where('commande_no', $bon_no)->value('commande_no');
         $orderDetails = OrderDetail::where('commande_no', $bon_no)->get();
         return view('backend.pages.order.show', compact('orderDetails','code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('order.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        $order = Order::find($id);
        $suppliers  = Supplier::all();
        $addresses = Address::all();
        return view('backend.pages.order.edit', compact('order','suppliers','addresses'));
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
        if (is_null($this->user) || !$this->user->can('order.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        
    }

    public function validateCommand($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any order !');
        }
            Order::where('commande_no', '=', $commande_no)
                ->update(['status' => 2]);

        session()->flash('success', 'order has been validated !!');
        return back();
    }

    public function reject($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any order !');
        }

        Order::where('commande_no', '=', $commande_no)
                ->update(['status' => -1]);

        session()->flash('success', 'Order has been rejected !!');
        return back();
    }

    public function reset($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any order !');
        }

        Order::where('commande_no', '=', $commande_no)
                ->update(['status' => 1]);

        session()->flash('success', 'Order has been reseted !!');
        return back();
    }

    public function confirm($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order.confirm')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any order !');
        }

        Order::where('commande_no', '=', $commande_no)
                ->update(['status' => 3]);

        session()->flash('success', 'Order has been confirmed !!');
        return back();
    }

    public function approuve($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order.approuve')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any order !');
        }

        Order::where('commande_no', '=', $commande_no)
                ->update(['status' => 4]);

        session()->flash('success', 'Order has been confirmed !!');
        return back();
    }

    public function reception($commande_no)
    {
       if (is_null($this->user) || !$this->user->can('order.reception')) {
            abort(403, 'Sorry !! You are Unauthorized to take any order !');
        }

        Order::where('commande_no', '=', $commande_no)
                ->update(['status' => 5]);

        session()->flash('success', 'Order has been arrived !!');
        return back();
    }

    public function htmlPdf($commande_no)
    {
        if (is_null($this->user) || !$this->user->can('bon_commande.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $stat = Order::where('commande_no', $commande_no)->value('status');
        $description = Order::where('commande_no', $commande_no)->value('description');
        $date = Order::where('commande_no', $commande_no)->value('date');
        if($stat == 2 && $stat == 3 || $stat == 4 || $stat == 5){
           $code = Order::where('commande_no', $commande_no)->value('commande_no');

           $datas = OrderDetail::where('commande_no', $commande_no)->get();
           $pdf = PDF::loadView('backend.pages.document.bon_commande',compact('datas','code','setting','description','date'));

           Storage::put('public/pdf/bon_commande/'.$commande_no.'.pdf', $pdf->output());

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
        if (is_null($this->user) || !$this->user->can('order.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any order !');
        }

        $order = Order::where('commande_no',$commande_no)->first();
        if (!is_null($order)) {
            $order->delete();
            OrderDetail::where('commande_no',$commande_no)->delete();
        }

        session()->flash('success', 'Order has been deleted !!');
        return back();
    }
}
