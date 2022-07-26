<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payreq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayreqApiController extends Controller
{
    public function index()
    {
        $payreqs = Payreq::paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $payreqs
        ]);
    }

    public function search(Request $request)
    {
        $payreqs = Payreq::query();
        $q = $request->query('q');
        if ($q) {
            $payreqs->where('rab_no', 'like', '%' . strtolower($q) . '%');
        }
        $payreqs = $payreqs->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $payreqs
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'payreq_num' => 'required|unique:payreqs',
            'employee_id' => 'required',
            'payreq_type' => 'required',
            'payreq_idr' => 'required|integer',
            'approve_date' => 'required',
            'que_group' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $payreq = Payreq::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $payreq
        ]);
    }

    public function show($id)
    {
        $payreq = Payreq::find($id);

        if(!$payreq) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment Request not found' 
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $payreq
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'payreq_num' => 'string',
            'employee_id' => 'string',
            'payreq_type' => 'string',
            'payreq_idr' => 'integer',
            'approve_date' => 'string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        //cek project_code ada ga
        //menyusul

        if ($request->has('payreq_num')) {
            $payreq_num = Payreq::where('payreq_num', $request->payreq_num)->first();
            if ($payreq_num) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment Request already exists'
                ], 400);
            }
        }

        //cek BUC ada ga
        $payreq = Payreq::find($id);
        if (!$payreq) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment Request not found'
            ]);
        }

        $payreq->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $payreq
        ]);
    }

    public function destroy($id)
    {
        $payreq = Payreq::find($id);
        if (!$payreq) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment Request not found'
            ]);
        }
        $payreq->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Payment Request deleted'
        ]);
    }
}
