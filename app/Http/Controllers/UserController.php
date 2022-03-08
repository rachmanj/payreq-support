<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $projects = ['000H', '001H', '011C', '017C', '021C', '022C', '023C', 'APS'];
        $employee = Employee::orderBy('fullname', 'asc')->get();


        return view('users.index', compact('projects', 'employee'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name'          => 'required|min:3|max:255',
            'username'      => 'required|min:3|max:20|unique:users',
            'email'         => 'required|email:dns|unique:users',
            'project_code'  => 'required',
            'password'      => 'min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        $user->is_active = 1;
        $user->employee_id = $request->employee_id;
        $user->save();
        
        $user->assignRole('user');

        return redirect()->route('users.index')->with('success', 'New User successfuly created!!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $projects = ['000H', '001H', '011C', '017C', '021C', '022C', '023C', 'APS'];
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->getRoleNames()->toArray();
        $permissions = Permission::all();
        $userPermissions = $user->getPermissionNames()->toArray();
        $employee = Employee::orderBy('fullname', 'asc')->get();

        return view('users.edit', compact('user', 'projects', 'roles', 'userRoles', 'employee'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required|min:3|max:255',
            'username'      => 'required|min:3|max:20|unique:users,username,'.$id,
            'email'         => 'required|email:dns|unique:users,email,'.$id,
            'project_code'  => 'required',
        ]);

        $user = User::find($id);

        if ($request->password) {
            $this->validate($request, [
                'password'      => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'
            ]);

            $user->password = Hash::make($request->password);
        } 

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->project_code = $request->project_code;
        $user->employee_id = $request->employee_id;

        $user->save();

        $user->syncRoles($request->input('role'));

        return redirect()->route('users.index')->with('success', 'User successfuly updated!!');

    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->username === 'superadmin') {
            return redirect()->route('users.index')->with('error', 'You cannot delete this user');
        }

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted');
    }

    public function data()
    {
        $users = User::all();

        return datatables()->of($users)
                ->editColumn('created_at', function ($users) {
                    return date('d-m-Y', strtotime($users->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', 'users.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
