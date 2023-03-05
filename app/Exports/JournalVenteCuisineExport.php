<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\FactureRestaurantDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class JournalVenteCuisineExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $d1 = request()->input('start_date');
        $d2 = request()->input('end_date');

        $startDate = Carbon::parse($d1)->format('Y-m-d');
        $endDate = Carbon::parse($d2)->format('Y-m-d');

        $start_date = $startDate.' 00:00:00';
        $end_date = $endDate.' 23:59:59';
        return FactureRestaurantDetail::select(
                        DB::raw('article_id,invoice_date,invoice_number,commande_no,item_price,item_ct,item_tl,item_price_nvat,item_price_wvat,item_total_amount,employe_id,sum(item_quantity) as item_quantit'))->whereBetween('invoice_date',[$start_date,$end_date])->groupBy('invoice_date','article_id','item_price','invoice_number','commande_no','item_ct','item_tl','item_price_nvat','item_price_wvat','item_total_amount','employe_id')->orderBy('invoice_date')->get();
    }

    public function map($factureRestaurantDetail) : array {
        return [
            $factureRestaurantDetail->id,
            Carbon::parse($factureRestaurantDetail->invoice_date)->format('d/m/Y'),
            $factureRestaurantDetail->commande_no,
            $factureRestaurantDetail->invoice_number,
            $factureRestaurantDetail->article->name,
            $factureRestaurantDetail->article->specification,
            $factureRestaurantDetail->item_quantit,
            $factureRestaurantDetail->item_price,
            //$factureRestaurantDetail->item_ct,
            //$factureRestaurantDetail->item_tl,
            //$factureRestaurantDetail->item_price_nvat,
            //$factureRestaurantDetail->item_price_wvat,
            $factureRestaurantDetail->item_total_amount,
            $factureRestaurantDetail->employe->name
        ] ;
 
 
    }

    public function headings() : array {
        return [
            '#',
            'Date',
            'Commande No',
            'Facture No',
            'Article',
            'Specification',
            'Quantite',
            'Prix Unitaire',
            //'Taxe de Consommation',
            //'Prelevement Forfaitaire Liberatoire',
            //'Prix HTVA',
            //'Prix de Vente TVAC',
            'Prix de Vente Total',
            'Serveur'
        ] ;
    }
}
