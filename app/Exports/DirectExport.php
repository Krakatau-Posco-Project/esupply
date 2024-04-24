<?php

namespace App\Exports;

use App\Models\TransactionDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DirectExport implements FromView, ShouldAutoSize
{
    protected $from_date;
    protected $to_date;

    function __construct($from_date,$to_date) {
            $this->from_date = $from_date;
            $this->to_date = $to_date;
    }

    public function view(): View
    {
        return view('main.admin.export_direct', [
            // 'data' => RequestItem::with(['item' => function ($query) {
            //                             $query->select('id', 'item_name');
            //                         }])
            //                         ->with(['histories' => function ($query) {
            //                             $query->select('id_user', 'id_item', 'pickup_date')->orderby('pickup_date','desc');
            //                         }])
            //                         ->with(['employee.orgunit' => function ($query) {
            //                             $query->select('id_org_unit','org_unit_name');
            //                         }])
            //                         ->with(['employee' => function ($query) {
            //                             $query->select('id_user', 'id_emp', 'name', 'org_unit', 'cell_phone');
            //                         }])
            //                         ->whereIn('status',['Approved','Assign','Completed'])
            //                         ->whereBetween('created_at',[ $this->from_date,$this->to_date])->get()
            'data' => TransactionDetail::with(['transaction' => function ($query) {
                                            $query->select('id', 'id_emp', 'name', 'orgunit', 'transactionnumber', 'purpose');
                                        }])
                                        ->with(['item' => function ($query) {
                                            $query->select('id', 'item_code', 'item_name', 'item_unit', 'classification');
                                        }])
                                        ->whereHas('transaction', function ($query){
                                            $query->where('purchase_type','Direct Pick Up');
                                        })
                                        ->orderBy('created_at', 'ASC')->whereBetween('created_at',[ $this->from_date,$this->to_date])->get()
        ]);
    }
}
