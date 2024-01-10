<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Exports\PermissionExport;
use App\Imports\PermissionImport;

use Maatwebsite\Excel\Facades\Excel;
use DB;

class RoleController extends Controller
{
    public function PermissionAll()
    {
        $permissions = Permission::latest()->get();
        return view('backend.pages.permission.permission_all', compact('permissions'));

    } // End Method

    public function PermissionAdd()
    {
        return view('backend.pages.permission.permission_add');

    } // End Method

    public function PermissionStore(Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permission.all')->with($notification);

    } //End Method

    public function PermissionEdit($id)
    {
        $permission = Permission::find($id);

        return view('backend.pages.permission.permission_edit', compact('permission'));

    } // End Method

    public function PermissionUpdate(Request $request)
    {
        $permission_id = $request->id;
         
        Permission::find($permission_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permission.all')->with($notification);

    } // End Method

    public function PermissionDelete($id)
    {
        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Permission Data Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function PermissionImport()
    {
        return view('backend.pages.permission.permission_import');

    } // End Method

    public function Export()
    {
        return Excel::download(new PermissionExport, 'permission.xlsx');

    } // End Method

    public function Import(Request $request)
    {
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' => 'Permission Data Imported Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method




    ////////////// All Roles Method ////////////////

    public function RoleAll()
    {
        $roles = Role::latest()->get();
        return view('backend.pages.role.role_all', compact('roles'));

    } // End Method

    public function RoleAdd()
    {
        return view('backend.pages.role.role_add');

    } // End Method


    public function RoleStore(Request $request)
    {
        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.all')->with($notification);

    } // End Method

    public function RoleEdit($id)
    {
        $role = Role::find($id);
        return view('backend.pages.role.role_edit', compact('role'));

    } // End Method 

    public function RoleUpdate(Request $request)
    {
        $role_id =  $request->id;

        Role::find($role_id)->update([
            'name' => $request->name
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.all')->with($notification);

    } // End Method

    public function RoleDelete($id)
    {
        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Role Data Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method



    ////////////// All Roles and Permission Method ////////////////
    
    public function RolePermissionAdd()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();

        return view('backend.pages.roles_setup.role_permission_add', compact('roles', 'permissions', 'permission_groups'));

    }

    public function RolePermissionStore(Request $request)
    {
        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = array(
            'message' => 'Role and Permission Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.permission.all')->with($notification);


    } // ENd Method

    public function RolePermissionAll()
    {
        $roles = Role::all();
        return view('backend.pages.roles_setup.role_permission_all', compact('roles'));
 
    } // End Method

    public function AdminRoleEdit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();

        return view('backend.pages.roles_setup.role_permission_edit', compact('role', 'permissions', 'permission_groups'));

    } // End Method

    public function AdminRoleUpdate(Request $request, $id)
    {
        $role = Role::find($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.permission.all')->with($notification);

    } // End Method

    public function AdminRoleDelete($id)
    {
        $role = Role::find($id);
        if (!is_null($role)) {
            $role->delete();
        }
        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // ENd Method





}
