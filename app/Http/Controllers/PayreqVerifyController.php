<?php

namespace App\Http\Controllers;

use App\Models\Payreq;
use Illuminate\Http\Request;

class PayreqVerifyController extends Controller
{
    public function index()
    {
        return view('verify.index');
    }

    public function update(Request $request, $id)
    {
        if($request->verify_date) {
            $verify_date = $request->verify_date;
        } else {
            $verify_date = date('Y-m-d');
        }

        $payreq = Payreq::findOrFail($id);
        $payreq->verify_date = $verify_date;
        $payreq->save();

        return redirect()->route('verify.index')->with('success', 'Payment Request updated');
    }

    public function data()
    {
        $payreqs = Payreq::select(
                        'id', 
                        'payreq_num', 
                        'employee_id', 
                        'approve_date', 
                        'payreq_idr', 
                        'outgoing_date',
                        'realization_num',
                        'realization_date',
                    )
                    ->selectRaw('datediff(now(), realization_date) as days')
                    ->whereNotNull('realization_date')
                    ->whereNull('verify_date')
                    ->orderBy('realization_date', 'asc')
                    ->get();

        return datatables()->of($payreqs)
                ->editColumn('approve_date', function ($payreq) {
                    return date('d-m-Y', strtotime($payreq->approve_date));
                })
                ->editColumn('outgoing_date', function ($payreq) {
                    return date('d-m-Y', strtotime($payreq->outgoing_date));
                })
                ->editColumn('realization_date', function ($payreq) {
                    return date('d-m-Y', strtotime($payreq->realization_date));
                })
                ->editColumn('payreq_idr', function ($payreq) {
                    return number_format($payreq->payreq_idr, 0);
                })
                ->addColumn('employee', function ($payreq) {
                    return $payreq->employee->fullname;
                })
                ->addIndexColumn()
                ->addColumn('action', 'verify.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
