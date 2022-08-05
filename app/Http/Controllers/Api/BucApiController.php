<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BucApiController extends Controller
{
    public function index(Request $request)
    {
        $bucs = Buc::query();

        $q = $request->query('q');

        $bucs->when($q, function ($query, $q) {
            return $query->whereRaw("rab_no LIKE '%".strtolower($q)."%'");
        });

        return response()->json([
            'status' => 'success',
            'data' => $bucs->paginate(10),
        ]);

    }

    public function search(Request $request)
    {
        $bucs = Buc::query();
        $q = $request->query('q');
        if ($q) {
            $bucs->where('rab_no', 'like', '%' . strtolower($q) . '%');
        }
        $bucs = $bucs->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $bucs
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'rab_no' => 'required|unique:bucs',
            'date' => 'required',
            'description' => 'required|string',
            'project_code' => 'required|string',
            'budget' => 'required',
        ];

        $data = $request->all();

        $validated = Validator::make($data, $rules);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()
            ], 400);
        }

        $buc = Buc::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $buc
        ]);
    }

    public function show($id)
    {
        $buc = Buc::find($id);

        if(!$buc) {
            return response()->json([
                'status' => 'error',
                'message' => 'BUC not found' 
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $buc
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'rab_no' => 'string',
            'description' => 'string',
            'project_code' => 'string',
            'budget' => 'integer',
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

        if ($request->has('rab_no')) {
            $rab_no = Buc::where('rab_no', $request->rab_no)->first();
            if ($rab_no) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'RAB No already exists'
                ], 400);
            }
        }

        //cek BUC ada ga
        $buc = Buc::find($id);
        if (!$buc) {
            return response()->json([
                'status' => 'error',
                'message' => 'BUC not found'
            ]);
        }

        $buc->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $buc
        ]);
    }

    public function destroy($id)
    {
        $buc = Buc::find($id);
        if (!$buc) {
            return response()->json([
                'status' => 'error',
                'message' => 'BUC not found'
            ]);
        }
        $buc->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'BUC deleted'
        ]);
    }
}
