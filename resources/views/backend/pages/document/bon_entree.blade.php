<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
             width: 82px;
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
                           &nbsp;&nbsp; Bon d'entree
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
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Designation</th>
                                    <th>Specification</th>
                                    <th>Quantite</th>
                                    <th>Unité</th>
                                    <th>Categorie</th>
                                    <th>Valeur Unitaire</th>
                                    <th>Valeur Total</th>
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
                                    <td>{{ $data->article->categoryRayon->category->name }}</td>
                                    <td>{{ number_format($data->unit_price,0,',','.' )}}fbu</td>
                                    <td>{{ number_format($data->total_value,0,',','.' )}}fbu</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="6"></th>
                                    <th>{{ number_format($totalValue,0,',','.') }}fbu</th>
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

                        <div style="float: right center; margin-left: 200px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;Gestionnaire du Stock et signature
                            <div>
                                &nbsp;&nbsp;{{ $gestionnaire }}
                            </div>
                        </div>
                        <div style="float: right;margin-right: 15px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;Remettant et signature
                            <div>
                                &nbsp;&nbsp;{{ $remettant }}
                            </div>
                        </div>
                    </div>
 
            </div>
        </div>
    </div>
</div>
</body>
</html>

