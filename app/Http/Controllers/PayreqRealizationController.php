<?php

namespace App\Http\Controllers;

use App\Models\Payreq;
use Illuminate\Http\Request;

class PayreqRealizationController extends Controller
{
    public function index()
    {
        return view('realization.index');
    }

    public function edit($id)
    {
        $payreq = Payreq::findOrFail($id);

        return view('realization.edit', compact('payreq'));
    }

    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'realization_num' => 'required|unique:tbl_payreq',
        ]);

        $payreq = Payreq::findOrFail($id);

        if($request->realization_amount){
            $realization_amount = $request->realization_amount;
        } else {
            $realization_amount = $payreq->payment_idr;
        }

        if ($request->realization_date) {
            $realization_date = $request->realization_date;
        } else {
            $realization_date = date('Y-m-d');
        }

        $payreq->realization_num = $request->realization_num;
        $payreq->realization_amount = $realization_amount;
        $payreq->realization_date = $realization_date;
        $payreq->save();

        return redirect()->route('realization.index')->with('success', 'Payment Request updated');
    }

    public function data()
    {
        $payreqs = Payreq::select(
                        'id', 
                        'payreq_num', 
                        'employee_id', 
                        'approve_date', 
                        'payreq_type', 
                        'payreq_idr', 
                        'outgoing_date',
                        'buc_id',
                    )
                    ->selectRaw('datediff(now(), outgoing_date) as days')
                    ->where('payreq_type', 'Advance')
                    ->whereNotNull('outgoing_date')
                    ->whereNull('realization_date')
                    ->orderBy('outgoing_date', 'asc')
                    ->get();

        return datatables()->of($payreqs)
                ->editColumn('payreq_num', function($payreq) {
                    if($payreq->buc_id) {
                        return $payreq->payreq_num . ' ' . '<i class="fas fa-check"></i>';
                    }
                    return $payreq->payreq_num;
                })
                ->editColumn('approve_date', function ($payreq) {
                    return date('d-m-Y', strtotime($payreq->approve_date));
                })
                ->editColumn('outgoing_date', function ($payreq) {
                    return date('d-m-Y', strtotime($payreq->outgoing_date));
                })
                ->editColumn('payreq_idr', function ($payreq) {
                    return number_format($payreq->payreq_idr, 0);
                })
                ->addColumn('employee', function ($payreq) {
                    return $payreq->employee->fullname;
                })
                ->addIndexColumn()
                ->addColumn('action', 'realization.action')
                ->rawColumns(['action', 'payreq_num'])
                ->toJson();
    }
}
