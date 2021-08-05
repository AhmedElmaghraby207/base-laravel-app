<?php

namespace App\Http\Controllers\Dashboard;

use App\Admin;
use App\Repositories\Admins\AdminsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminsController extends BaseController
{
    protected $adminRep;

    function __construct(AdminsRepositoryInterface $adminRep)
    {
        parent::__construct();
        $this->middleware('permission:admin-list', ['only' => ['index', 'list', 'show']]);
        $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
        $this->adminRep = $adminRep;
    }

    public function index()
    {
        return view('dashboard.admins.index');
    }

    public function list(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $adminId = session()->get('user_admin')->id;
        $admins = $this->adminRep->list(false, ['name' => $name, 'email' => $email, /*'adminId' => $adminId*/]);
        return datatables()->of($admins)->toJson();
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        return view('dashboard.admins.show')->with(['admin' => $admin]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('dashboard.admins.create')->with('roles', $roles);
    }

    public function store(Request $request)
    {
        $validator_array = [
            'name' => 'required',
            'email' => [
                'required',
                'max:255',
                Rule::unique('admins'),
            ],
            'password' => 'required|confirmed|min:6',
            'roles' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:4096'
        ];

        $validator = Validator::make($request->all(), $validator_array);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'fail', 'error_message' => 'validation error', 'errors' => $validator->errors()]);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }

        $admin_array = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => md5($request->password)
        ];

        $admin_query = Admin::query();
        $created_admin = $admin_query->create($admin_array);

        if ($created_admin) {
            $created_admin->assignRole($request->input('roles'));
            if ($image = $request->image) {
                if ($created_admin->image) {
                    @unlink($created_admin->getOriginal('image'));
                }
                $path = 'uploads/admins/admin_' . $created_admin->id . '/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $created_admin->image = $path . $image_new_name;

                $created_admin->save();
            }

            session()->flash('success_message', trans('main.created_alert_message', ['attribute' => Lang::get('admin.attribute_name')]));
            return redirect()->route('admin.index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = Role::all();
        $adminRoles = $admin->roles ? $admin->roles->all() : [];
        return view('dashboard.admins.edit')->with(['admin' => $admin, 'roles' => $roles, 'adminRoles' => $adminRoles]);
    }

    public function update($id, Request $request)
    {
        $validator_array = [
            'name' => 'required',
            'email' => [
                'required',
                'max:255',
                Rule::unique('admins')->ignore($id),
            ],
            'roles' => 'required',
//            'image' => 'mimes:jpg,jpeg,png,bmp,tiff|max:4096'
        ];

        if ($request->password) {
            $validator_array['password'] = 'required|confirmed|min:6';
        }

        $validator = Validator::make($request->all(), $validator_array);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'fail', 'error_message' => 'validation error', 'errors' => $validator->errors()]);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }

        $admin_array = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if ($request->password) {
            $admin_array['password'] = md5($request->password);
        }

        $updated_admin = Admin::query()->find($id);
        $updated_admin->update($admin_array);
        if ($updated_admin) {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $updated_admin->assignRole($request->input('roles'));

            if ($image = $request->image) {
                if ($updated_admin->image) {
                    @unlink($updated_admin->getOriginal('image'));
                }
                $path = 'uploads/admins/admin_' . $updated_admin->id . '/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $updated_admin->image = $path . $image_new_name;

                $updated_admin->save();
            }

            session()->flash('success_message', trans('main.updated_alert_message', ['attribute' => Lang::get('admin.attribute_name')]));
            return redirect()->route('admin.index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }


    }

    public function destroy($id, Request $request)
    {
        $admin = Admin::find($id);
        $deleted_admin = $admin->delete();

        if ($deleted_admin) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'success_message' => trans('main.deleted_alert_message', ['attribute' => Lang::get('admin.attribute_name')]),
                ]);
            }
            session()->flash('success_message', trans('main.deleted_alert_message', ['attribute' => Lang::get('admin.attribute_name')]));
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
