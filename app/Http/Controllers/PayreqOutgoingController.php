<?php

namespace App\Http\Controllers;

use App\Models\Payreq;
use Illuminate\Http\Request;

class PayreqOutgoingController extends Controller
{
    public function index()
    {
        return view('outgoing.index');
    }

    public function edit($id)
    {
        $payreq = Payreq::findOrFail($id);

        return view('outgoing.edit', compact('payreq'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'outgoing_date' => 'required',
        ]);

        $payreq = Payreq::findOrFail($id);
        $payreq->outgoing_date = $request->outgoing_date;
        $payreq->save();

        return redirect()->route('outgoing.index')->with('success', 'Payment Request updated');
    }

    public function destroy($id)
    {
        $payreq = Payreq::findOrFail($id);
        $payreq->delete();

        return redirect()->route('approved.index')->with('success', 'Payment Request deleted');
    }

    public function data()
    {
        $payreqs = Payreq::select('id', 'payreq_num', 'employee_id', 'approve_date', 'payreq_type', 'payreq_idr', 'outgoing_date')
                    ->selectRaw('datediff(now(), approve_date) as days')
                    ->whereNull('outgoing_date')
                    ->orderBy('approve_date', 'asc')
                    ->get();

        return datatables()->of($payreqs)
                ->editColumn('approve_date', function ($payreq) {
                    return date('d-m-Y', strtotime($payreq->approve_date));
                })
                ->editColumn('payreq_idr', function ($payreq) {
                    return number_format($payreq->payreq_idr, 0);
                })
                ->addColumn('employee', function ($payreq) {
                    return $payreq->employee->fullname;
                })
                ->addIndexColumn()
                ->addColumn('action', 'outgoing.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
