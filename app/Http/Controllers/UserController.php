<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function data()
    {
        $users = User::all();
        
        return datatables()->of($users)
            ->editColumn('created_at', function ($users) {
                 return Carbon::parse($users->created_at)->diffForHumans();
                
            })
            ->editColumn('approval_level', function ($users) {
                if ($users->approval_level == 1) {
                    return 'Level 1';
                } elseif ($users->approval_level == 2){
                    return 'Level 2';
                } else {
                    return 'No';
                }
            })
            ->addIndexColumn()
            ->addColumn('action', 'users.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
