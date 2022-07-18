<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BucApiController extends Controller
{
    public function index()
    {
        $bucs = Buc::paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $bucs
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
        
        // $bucs = Buc::where('rab_no', 'like', '%' . strtolower($q) . '%')->paginate(10);

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

        $bucs = Buc::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $bucs
        ]);
    }
}
