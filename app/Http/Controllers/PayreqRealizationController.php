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

        if ($request->realization_date) {
            $realization_date = $request->realization_date;
        } else {
            $realization_date = date('Y-m-d');
        }

        $payreq = Payreq::findOrFail($id);
        $payreq->realization_num = $request->realization_num;
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
                        'outgoing_date'
                    )
                    ->selectRaw('datediff(now(), outgoing_date) as days')
                    ->where('payreq_type', 'Advance')
                    ->whereNotNull('outgoing_date')
                    ->whereNull('realization_date')
                    ->orderBy('outgoing_date', 'asc')
                    ->get();

        return datatables()->of($payreqs)
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
                ->rawColumns(['action'])
                ->toJson();
    }
}
