<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\ReceptionDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JournalReceptionExport implements FromCollection, WithMapping, WithHeadings
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
        return ReceptionDetail::select(
                        DB::raw('article_id,created_at,receptionist,invoice_no,supplier,unit_price,sum(quantity) as quantit'))->whereBetween('created_at',[$start_date,$end_date])->groupBy('created_at','article_id','receptionist','invoice_no','receptionist','unit_price','supplier')->orderBy('created_at')->get();
    }

    public function map($receptionDetail) : array {
        return [
            $receptionDetail->id,
            Carbon::parse($receptionDetail->created_at)->format('d/m/Y'),
            $receptionDetail->supplier,
            $receptionDetail->article->name,
            $receptionDetail->article->specification,
            number_format($receptionDetail->unit_price,0,',',' '),
            $receptionDetail->quantit,
            number_format(($receptionDetail->quantit * $receptionDetail->unit_price),0,',',' '),
            $receptionDetail->receptionnist
        ] ;
 
 
    }

    public function headings() : array {
        return [
            '#',
            'Date',
            'facture No',
            'Fournisseur',
            'Article',
            'Specification',
            'Prix Unitaire',
            'Quantite Recu',
            'Valeur Totale',
            'Receptionniste'
        ] ;
    }
}
