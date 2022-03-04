<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->getRoleNames()->toArray();
        $permissions = Permission::all();
        $userPermissions = $user->getPermissionNames()->toArray();

        // return $userPermissions; //$user->assignRole('admin');
        // die;

        return view('users.edit', compact(
            'user',
            'roles', 
            'userRoles',
            'permissions',
            'userPermissions'
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email' => ['required', 'unique:users,email,' . $id],
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->input('role'));

        return redirect()->route('users.index')->with('success', 'User successfully updated!');
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
