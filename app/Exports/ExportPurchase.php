<?php

namespace App\Exports;

use Illuminate\View\View;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportPurchase implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }
    function __construct($id)
    {
        $this->id = $id;
        $this->total = 0;
    }
    public function view(): View
    {

        // $transaction = Transaction::with('detail')->where('id', $this->id)->get();
        $transaction = Transaction::with(['detail' => function ($query) {
            $query->with('items');
        }])->firstWhere('id', $this->id);
        $this->total = count($transaction->detail);
        return view('main.admin.purchasedownload', [
            'transaction' => $transaction
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I' . $this->total + 1)->applyFromArray($styleArray);
    }
}
