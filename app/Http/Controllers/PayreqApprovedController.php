<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payreq;
use Illuminate\Http\Request;

class PayreqApprovedController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('fullname', 'asc')->get();

        return view('approved.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'payreq_num' => 'required|unique:tbl_payreq',
            'payreq_idr' => 'required',
        ]);

        if($request->approve_date) {
            $approve_date = $request->approve_date;
        } else {
            $approve_date = date('Y-m-d');
        }

        $payreq = new Payreq();
        $payreq->employee_id = $request->employee_id;
        $payreq->payreq_num = $request->payreq_num;
        $payreq->approve_date = $approve_date;
        $payreq->payreq_type = $request->payreq_type;
        $payreq->que_group = $request->que_group;
        $payreq->payreq_idr = $request->payreq_idr;
        $payreq->remarks = $request->remarks;
        $payreq->save();

        return redirect()->route('approved.index')->with('success', 'Payment Request created');
    }

    public function edit($id)
    {
        $payreq = Payreq::findOrFail($id);
        $employees = Employee::orderBy('fullname', 'asc')->get();

        return view('approved.edit', compact('payreq', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'payreq_num' => 'required|unique:users,username,'.$id,
            'approve_date' => 'required',
            'payreq_type' => 'required',
            'payreq_idr' => 'required',
        ]);

        $payreq = Payreq::findOrFail($id);
        $payreq->employee_id = $request->employee_id;
        $payreq->payreq_num = $request->payreq_num;
        $payreq->approve_date = $request->approve_date;
        $payreq->payreq_type = $request->payreq_type;
        $payreq->que_group = $request->que_group;
        $payreq->payreq_idr = $request->payreq_idr;
        $payreq->remarks = $request->remarks;
        $payreq->save();

        return redirect()->route('approved.index')->with('success', 'Payment Request updated');
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
                    ->orderBy('approve_date', 'desc')
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
                ->addColumn('action', 'approved.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
