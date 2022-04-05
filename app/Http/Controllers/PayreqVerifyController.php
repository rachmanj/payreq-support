<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Payreq;
use App\Models\Transaksi;
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
        
        //cek apakah payreq_idr berbeda dengan realization_amount
        if($payreq->payreq_idr > $payreq->realization_amount) {
            $variant = $payreq->payreq_idr - $payreq->realization_amount;
            if($payreq->buc_id) {
                $account = Account::where('account_no', '111115')->first();
                $description = 'Kelebihan PR ' . $payreq->payreq_num .', RAB no' . $payreq->buc->rab_no;
            } else {
                $account = Account::where('account_no', '111111')->first();
                $description = 'Kelebihan PR ' . $payreq->payreq_num;
            }
            $account->balance = $account->balance + $variant;
            $account->save();

            // create transaksi
            $transaksi = new Transaksi();
            $transaksi->payreq_id = $payreq->id;
            $transaksi->account_id = $account->id;
            $transaksi->description = $description;
            $transaksi->type = 'plus';
            $transaksi->amount = $variant;
            $transaksi->save();

        } else if ($payreq->payreq_idr < $payreq->realization_amount) {
            $variant = $payreq->realization_amount - $payreq->payreq_idr;
            if($payreq->buc_id) {
                $account = Account::where('account_no', '111115')->first();
                $description = 'Kekurangan PR ' . $payreq->payreq_num .', RAB no' . $payreq->buc->rab_no;

            } else {
                $account = Account::where('account_no', '111111')->first();
                $description = 'Kekurangan PR ' . $payreq->payreq_num;        
            }
            $account->balance = $account->balance - $variant;
            $account->save();
            // create transaksi
            $transaksi = new Transaksi();
            $transaksi->payreq_id = $payreq->id;
            $transaksi->account_id = $account->id;
            $transaksi->description = $description;
            $transaksi->type = 'plus';
            $transaksi->amount = $variant;
            $transaksi->save();
        } 

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
                        'realization_amount',
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
                ->editColumn('realization_amount', function ($payreq) {
                    if($payreq->realization_amount == null) return '-';
                    return number_format($payreq->realization_amount, 0);
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
