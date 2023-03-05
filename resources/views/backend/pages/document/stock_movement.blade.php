<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
        }

    </style>

<body>
<div>
    <div>
        <div>
            <div>
                <div>
                   <img src="img/eden_logo.png" width="200" height="65">
                </div>
                <div>
                    <div style="float: left;">
                          <small> &nbsp;&nbsp;{{$setting->commune}}-{{$setting->zone}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->rue}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->telephone1}}-{{$setting->telephone2}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->email}}</small>
                    </div>
                    <br>
                    <div style="float: right; border-top-right-radius: 10px solid black;border-top-left-radius: 10px solid black;border-bottom-right-radius: 10px solid black;border-bottom-left-radius: 10px solid black; background-color: rgb(150,150,150);width: 242px;padding: 20px;">
                        <small>
                           &nbsp;&nbsp; JOURNAL GENERAL
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Date : Le {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br>
                    <div>
                        <h2 style="text-align: center;text-decoration: underline;">JOURNAL GENERAL DE MOUVEMENT DU STOCK</h2>
                    </div>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Article</th>
                                    <th>Specification</th>
                                    <th>C.U.M.P</th>
                                    <th>Q.S. Initial</th>
                                    <th style="background-color: rgb(150,150,150);">Val. S. Initial</th>
                                    <th>Q.Entrée</th>
                                    <th style="background-color: rgb(150,150,150);">Val. Entrée</th>
                                    <th style="background-color: rgb(150,150,150);">Q.S. Total</th>
                                    <th>Q.Sortie/Vente</th>
                                    <th style="background-color: rgb(150,150,150);">Val. Sortie/Vente</th>
                                    <th>Commande/Facture No</th>
                                    <th style="background-color: rgb(150,150,150);">Q.S. Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->specification }}</td>
                                    <td>{{ number_format($data->article->unit_price,0,',',' ') }}</td>
                                    <td>{{ $data->quantity_stock_initial }}</td>
                                    <td style="background-color: rgb(150,150,150);">{{ number_format(($data->quantity_stock_initial * $data->article->unit_price),0,',',' ')}}</td>
                                    <td>{{ $data->quantity_stockin }}</td>
                                    <td>{{ number_format(($data->quantity_stockin * $data->article->unit_price),0,',',' ')  }}</td>
                                    @php $stockTotal = $data->quantity_stock_initial + $data->quantity_stockin
                                    @endphp
                                    <td style="background-color: rgb(150,150,150);">{{ $stockTotal }}</td>
                                    <td>@if($data->quantity_stockout){{ $data->quantity_stockout }}@elseif($data->quantity_sold){{ $data->quantity_sold }} @endif</td> 
                                    <td>@if($data->quantity_stockout){{ number_format(($data->quantity_stockout * $data->article->unit_price),0,',',' ')}} @elseif($data->quantity_sold) {{ number_format($data->value_sold,0,',',' ') }} @endif</td>
                                    <td>@if($data->commande_boisson_no){{ $data->commande_boisson_no }}@elseif($data->commande_cuisine_no) {{ $data->commande_cuisine_no }}@endif/{{ $data->facture_no }}</td>
                                    <td style="background-color: rgb(150,150,150);">{{ $stockTotal - $data->quantity_stockout }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br><br>
                    <div style="display: flex;">
                        <div style="float: left center; margin-right: 0;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;signature
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>
                        <div style="float: right;margin-right: 15px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;signature
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
 
            </div>
        </div>
    </div>
</div>
</body>
</html>

