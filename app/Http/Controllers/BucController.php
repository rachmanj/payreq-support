<?php

namespace App\Http\Controllers;

use App\Models\Buc;
use App\Models\Payreq;
use Illuminate\Http\Request;

class BucController extends Controller
{
    public function index()
    {
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];

        return view('bucs.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'rab_no'    => 'required|unique:bucs',
            'date'  => 'required',
            'description' => 'required',
            'project_code' => 'required',
            'budget' => 'required',
        ]);

        $buc = new Buc();
        $buc->rab_no = $request->rab_no;
        $buc->date = $request->date;
        $buc->description = $request->description;
        $buc->project_code = $request->project_code;
        $buc->budget = $request->budget;
        $buc->status = 'progress';
        $buc->save();

        return redirect()->route('bucs.index')->with('success', 'BUC created successfully');
    }

    public function edit($id)
    {
        $buc = Buc::find($id);
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];

        return view('bucs.edit', compact('buc', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'rab_no'    => 'required|unique:bucs,rab_no,'.$id,
            'date'  => 'required',
            'description' => 'required',
            'project_code' => 'required',
            'budget' => 'required',
        ]);

        $buc = Buc::find($id);
        $buc->rab_no = $request->rab_no;
        $buc->date = $request->date;
        $buc->description = $request->description;
        $buc->project_code = $request->project_code;
        $buc->budget = $request->budget;
        $buc->status = $request->status;
        $buc->save();

        return redirect()->route('bucs.index')->with('success', 'BUC updated successfully');
    }

    public function show($id)
    {
        $buc = Buc::find($id);
        $advances = Payreq::where('buc_id', $id)->whereNotNull('outgoing_date')
                    ->whereNull('realization_amount')
                    ->sum('payreq_idr');
        $realizations = Payreq::where('buc_id', $id)->whereNotNull('realization_amount')
                        ->sum('realization_amount');
        $total_release = $advances + $realizations;

        return view('bucs.show', compact('buc', 'total_release'));
    }

    public function destroy($id)
    {
        $buc = Buc::find($id);
        if($buc->payreqs->count() > 0) {
            return redirect()->route('bucs.index')->with('error', 'BUC cannot be deleted because it has payreqs');
        }

        $buc->delete();

        return redirect()->route('bucs.index')->with('success', 'BUC deleted successfully');
    }

    public function data()
    {
        $bucs = Buc::orderBy('date', 'desc')->get();

        return datatables()->of($bucs)
            ->editColumn('date', function ($buc) {
                return date('d-m-Y', strtotime($buc->date)); 
            })
            ->editColumn('budget', function ($buc) {
                return number_format($buc->budget, 2);
            })
            ->editColumn('advance', function ($buc) {
                 $payreq = Payreq::where('buc_id', $buc->id)
                        ->whereNotNull('outgoing_date')
                        ->whereNull('realization_date');
                return number_format($payreq->sum('payreq_idr'), 2);
            })
            ->editColumn('realization', function ($buc) {
                $payreq = Payreq::where('buc_id', $buc->id)
                        ->whereNotNull('realization_date');
                return number_format($payreq->sum('payreq_idr'), 2);
            })
            ->addIndexColumn()
            ->addColumn('action', 'bucs.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function payreq_data($buc_id)
    {
        $payreqs = Payreq::where('buc_id', $buc_id)->whereNotNull('outgoing_date')
                    ->orderBy('approve_date', 'desc')
                    ->get();

        return datatables()->of($payreqs)
            ->editColumn('approve_date', function ($payreq) {
                return date('d-m-Y', strtotime($payreq->approve_date)); 
            })
            ->editColumn('employee', function ($payreq) {
                return $payreq->employee->fullname;
            })
            ->editColumn('amount', function ($payreq) {
                if($payreq->realization_amount != null){
                    return number_format($payreq->realization_amount, 2);
                } else {
                    return number_format($payreq->payreq_idr, 2);
                }
            })
            ->addIndexColumn()
            ->toJson();
    }



}
