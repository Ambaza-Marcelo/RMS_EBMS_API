<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             width: 75px;
             text-align: center;
        }
        .signature{
            display: flex;
        }
    </style>
</head>

<body>
<div>
    <div>
        <div>
            <div>
               <div>
                   <img src="img/eden_logo.png" width="150" height="65">
                </div>
                <div>
                    <div style="float: left;">
                          <small> &nbsp;&nbsp;{{$setting->commune}}-{{$setting->zone}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->rue}}</small><br>
                          <small>&nbsp;&nbsp;NIF : {{$setting->nif}}-RC : {{$setting->rc}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->telephone1}}-{{$setting->telephone2}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->email}}</small><br>
                    </div>
                    <div>
                        <small>
                           COMMANDE N<sup>o</sup> : {{ $facture->commande_no}}
                        </small><br>
                        <small>
                           FACTURE N<sup>o</sup> : {{ $facture->invoice_number}}
                        </small><br>
                        <small>
                           DU {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </small><br>
                    </div>
                    <br><br><br>
                    <hr>
                    <br>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>Article</th>
                                    <th>Qté</th>
                                    <th>P.U</th>
                                    <th>P.Total</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->item_quantity }}</td>
                                    <td>{{ number_format($data->item_price,0,',',' ' )}}fbu</td>
                                    <td>{{ number_format($data->item_total_amount,0,',',' ' )}}fbu</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="2"></th>
                                    <th>{{ number_format($totalValue,0,',',' ') }}fbu</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
                    <hr>
                    @if($facture->employe_id)
                        <small style="font-style: italic;">
                           Nom du Serveur : {{ $facture->employe->name}}
                        </small><br>
                        @endif
                    <hr>
                    <div style="display: flex;">
                        <div style="float: left center; margin-right: 0;width: 242px;padding-bottom: 40px;">
                                &nbsp;&nbsp;<i>Merci et bienvenue encore!</i>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
</body>
</html>

