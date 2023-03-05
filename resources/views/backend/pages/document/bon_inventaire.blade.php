<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             width: 100%;
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
                           &nbsp;&nbsp; Bon d'Inventaire
                        </small><br>
                        <small>
                           &nbsp;&nbsp; No: {{ $code }}
                        </small><br>

                        <small>
                           &nbsp;&nbsp; Date : Le {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br>
                    <div>
                        <h2 style="text-align: center;text-decoration: underline;">{{$title}}</h2>
                    </div>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Article</th>
                                    <th>Specification</th>
                                    <th>Qté Actuelle</th>
                                    <th>V.Unitaire Actuelle</th>
                                    <th style="background-color: rgb(150,150,150);">Valeur Stock Actuelle</th>
                                    <th>Nouvelle Qté</th>
                                    <th>Nouvelle V.U</th>
                                    <th>Nouvelle V du stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->specification }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ number_format($data->unit_price,0,',','.' )}}fbu</td>
                                    <td style="background-color: rgb(150,150,150);">{{ number_format($data->total_value,0,',','.' )}}fbu</td>
                                    <td>{{ $data->new_quantity }}</td>
                                    <td>{{ number_format($data->new_price,0,',','.' )}}fbu</td>
                                    <td>{{ number_format($data->new_total_value,0,',','.' )}}fbu</td>
                                </tr>
                                @endforeach
                            </tbody>
                             <tfoot>
                                <tr>
                                    <th>Totaux</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="4"></th>
                                    <th>{{number_format($totalValueActuelle,0,',','.')}}fbu</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="2"></th>
                                    <th>{{ number_format($totalValueNew,0,',','.') }}fbu</th>
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
                        <div style="float: left center; margin-right: 0;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;signature
                            <div>
                                &nbsp;&nbsp;
                                
                            </div>
                        </div>

                        <div style="float: right center; margin-left: 250px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;signature
                            <div>&nbsp;&nbsp;
                                
                            </div>
                        </div>
                        <div style="float: right;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;Gestionnaire et Signature
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

