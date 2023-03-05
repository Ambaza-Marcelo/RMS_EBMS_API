<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportExport implements FromCollection, WithMapping, WithHeadings
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
        return Report::select(
                        DB::raw('article_id,created_at,asker,quantity_stock_initial,sum(quantity_stockin) as quantity_in,sum(stock_total) as stock_tot,sum(quantity_stockout) as quantity_out'))->whereBetween('created_at',[$start_date,$end_date])->groupBy('created_at','article_id','asker','quantity_stock_initial')->orderBy('created_at')->get();
    }

    public function map($report) : array {
        return [
            $report->id,
            Carbon::parse($report->created_at)->format('d/m/Y'),
            $report->article->name,
            $report->article->specification,
            number_format($report->article->unit_price,0,',',' '),
            $report->quantity_stock_initial,
            number_format(($report->quantity_stock_initial * $report->article->unit_price),0,',',' '),
            $report->quantity_in,
            number_format(($report->quantity_in * $report->article->unit_price),0,',',' '),
            $report->quantity_stock_initial + $report->quantity_in,
            $report->quantity_out,
            number_format(($report->quantity_out * $report->article->unit_price),0,',',' '),
            $report->asker ? $report->asker : [],
            ($report->quantity_stock_initial + $report->quantity_in)-$report->quantity_out
        ] ;
 
 
    }

    public function headings() : array {
        return [
            '#',
            'Date',
            'Article',
            'Specification',
            'C.U.M.P',
            'Stock Initial',
            'V. S. Initial',
            'Entree',
            'V. Entree',
            'S. Total',
            'Q. Sortie',
            'V. Sortie',
            'Destination',
            'Demandeur',
            'S. Final'
        ] ;
    }
}
