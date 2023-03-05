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
                    <div style="float: right; border-top-right-radius: 10px solid black;border-top-left-radius: 10px solid black;border-bottom-right-radius: 10px solid black;border-bottom-left-radius: 10px solid black;background-color: rgb(150,150,150);width: 242px;padding: 20px;">
                        <small>
                           &nbsp;&nbsp; Bon de sortie
                        </small><br>
                        <small>
                           &nbsp;&nbsp; No : {{ $bon_no}}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Date : Le {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Article</th>
                                    <th>Quantité</th>
                                    <th>Unité</th>
                                    <th>Prix Unitaire</th>
                                    <th>Valeur Total</th>
                                    <th>Categorie</th>
                                    <th>Destination</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ $data->unit }}</td>
                                    <td>{{ number_format($data->article->unit_price,0,',','.' )}}fbu</td>
                                    <td>{{ number_format($data->total_value,0,',','.' )}}fbu</td>
                                    <td>{{ $data->article->category->name }}</td>
                                    <td>{{ $data->destination}} </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="4"></th>
                                    <th>{{ number_format($totalValue,0,',','.') }}fbu</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="2"></th>
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
                    <div style="display: flex;">
                        <div style="float: left;">
                            &nbsp;&nbsp;Gestionnaire du Stock et signature
                            <div>
                                &nbsp;&nbsp;{{ $gestionnaire }}
                            </div>
                        </div>
                        <div style="float: right;">
                            &nbsp;&nbsp;Demandeur et signature
                            <div>
                                &nbsp;&nbsp;{{ $demandeur }}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

