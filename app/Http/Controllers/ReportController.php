<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payreq;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function report1_index()
    {
        return view('reports.report1.index');
    }

    public function report1_display(Request $request)
    {
        $payreq = Payreq::where('payreq_num', $request->payreq_no)->first();
        
        return view('reports.report1.display', compact('payreq'));
    }

    public function report1_edit($id)
    {
        $payreq = Payreq::find($id);
        $employees = Employee::orderBy('fullname', 'asc')->get();

        return view('reports.report1.edit', compact('payreq', 'employees'));
    }

    public function report1_update(Request $request, $id)
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

        return redirect()->route('reports.report1.index')->with('success', 'Payment Request updated');
    }

    public function report1_destroy($id)
    {
        $payreq = Payreq::findOrFail($id);
        $payreq->delete();

        return redirect()->route('reports.report1.index')->with('success', 'Payment Request deleted');
    }
}
