<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\StockinDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JournalEntreeExport implements FromCollection, WithMapping, WithHeadings
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
        return StockinDetail::select(
                        DB::raw('article_id,created_at,handingover,unit_price,sum(quantity) as quantit'))->whereBetween('created_at',[$start_date,$end_date])->groupBy('created_at','article_id','handingover','receptionist','unit_price')->orderBy('created_at')->get();
    }

    public function map($stockinDetail) : array {
        return [
            $stockinDetail->id,
            Carbon::parse($stockinDetail->created_at)->format('d/m/Y'),
            $stockinDetail->article->name,
            $stockinDetail->article->specification,
            number_format($stockinDetail->unit_price,0,',',' '),
            $stockinDetail->quantit,
            number_format(($stockinDetail->quantit * $stockinDetail->unit_price),0,',',' '),
            $stockinDetail->handingover
        ] ;
 
 
    }

    public function headings() : array {
        return [
            '#',
            'Date',
            'Article',
            'Specification',
            'Prix Unitaire',
            'Quantite',
            'Valeur Totale',
            'Remettant'
        ] ;
    }
}
