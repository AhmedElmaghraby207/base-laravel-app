<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends BaseController
{
    function __construct()
    {
        parent::__construct();
        $this->middleware('permission:role-list', ['only' => ['index', 'list', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('dashboard.roles.index');
    }

    public function list(Request $request)
    {
        $name = $request->name;

        $roles = Role::query();
        if ($name) {
            $roles = $roles->where('name', 'like', '%' . $name . '%');
        }
        return datatables()->of($roles)->toJson();
    }

    public function create()
    {
        $permissions = Permission::get();
        return view('dashboard.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator_array = [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ];
        $validator = Validator::make($request->all(), $validator_array);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'fail', 'error_message' => 'validation error', 'errors' => $validator->errors()]);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }

        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'admin']);
        $role->syncPermissions($request->input('permissions'));

        session()->flash('success_message', trans('main.created_alert_message', ['attribute' => Lang::get('role.attribute_name')]));
        return redirect()->to(route('role.index'));
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('dashboard.roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $validator_array = [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($id),
            ],
            'permissions' => 'required',
        ];
        $validator = Validator::make($request->all(), $validator_array);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'fail', 'error_message' => 'validation error', 'errors' => $validator->errors()]);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        session()->flash('success_message', trans('main.updated_alert_message', ['attribute' => Lang::get('role.attribute_name')]));
        return redirect()->route('role.index');
    }

    public function destroy($id)
    {
        $deleted_role = DB::table("roles")->where('id', $id)->delete();

        if ($deleted_role) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'success_message' => trans('main.deleted_alert_message', ['attribute' => Lang::get('role.attribute_name')]),
                ]);
            }
            session()->flash('success_message', trans('main.deleted_alert_message', ['attribute' => Lang::get('role.attribute_name')]));
            return redirect()->back();
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'fail',
                    'error_message' => 'Something went wrong'
                ]);
            }
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }
}
