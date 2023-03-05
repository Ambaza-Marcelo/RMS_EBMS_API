<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\StockoutDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JournalSortieExport implements FromCollection, WithMapping, WithHeadings
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
        return StockoutDetail::select(
                        DB::raw('article_id,created_at,sum(quantity) as quantit'))->whereBetween('created_at',[$start_date,$end_date])->groupBy('created_at','article_id')->orderBy('created_at')->get();
    }

    public function map($stockoutDetail) : array {
        return [
            $stockoutDetail->id,
            Carbon::parse($stockoutDetail->created_at)->format('d/m/Y'),
            $stockoutDetail->article->name,
            $stockoutDetail->article->specification,
            number_format($stockoutDetail->article->unit_price,0,',',' '),
            $stockoutDetail->quantit,
            number_format(($stockoutDetail->quantit * $stockoutDetail->article->unit_price),0,',',' ')
        ] ;
 
 
    }

    public function headings() : array {
        return [
            '#',
            'Date',
            'Article',
            'Specification',
            'C.U.M.P',
            'Quantite Sortie',
            'Valeur Totale Sortie'
        ] ;
    }
}
