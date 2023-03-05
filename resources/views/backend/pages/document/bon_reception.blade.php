<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
             width: 85px;
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
                           &nbsp;&nbsp; Commande No: {{ $commande_no }}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Fournisseur: {{ $supplier }}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Facture No: {{ $invoice_no }}
                        </small><br>
                        <small>
                           &nbsp;&nbsp;Reception No: {{ $code }}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Date : Le {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br>
                    <div>
                        <h3 style="text-align: center;text-decoration: underline;">FICHE DE RECEPTION DES ARTICLES</h3>
                    </div>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Designation</th>
                                    <th>Specification</th>
                                    <th>Quantite</th>
                                    <th>Unité</th>
                                    <th>prix Unitaire</th>
                                    <th>Valeur Total</th>
                                    <th>Quantité Restant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->specification }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ $data->unit }}</td>
                                    <td>{{ number_format($data->unit_price,0,',','.' )}}fbu</td>
                                    <td>{{ number_format($data->total_value,0,',','.' )}}fbu</td>
                                    <td>{{ $data->remaining_quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="5"></th>
                                    <th>{{ number_format($totalValue,0,',','.') }}fbu</th>
                                    <th style="background-color: rgb(150,150,150);"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br><br>
                <div>
                    &nbsp;&nbsp;{{ $description }}
                </div>
                <br>
                <h4 style="text-decoration: underline;text-align: center;">Pour la commission de Reception :</h4>
                    <div style="display: flex;">
                        <div style="float: left;">
                            &nbsp;&nbsp;signature
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>

                        <div style="float: center;margin-left: 65%;">
                            &nbsp;&nbsp;signature
                            <div>
                            &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <br><br><br><br>
                        <h4 style="text-decoration: underline;text-align: center;">Pour le Gestionnaire du stock :</h4>
                        <div style="float: center;margin-left: 35%;">
                            &nbsp;&nbsp;signature
                            <div>
                            &nbsp;&nbsp;
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

