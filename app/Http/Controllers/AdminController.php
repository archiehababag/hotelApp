<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');

    } // End Method

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');

    } // End Method

    public function AdminLogin()
    {
        return view('admin.admin_login');

    } // End Method

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));

    } // End Method

    public function AdminProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $editData = User::find($id);
        $editData->name = $request->name;
        $editData->email = $request->email;
        $editData->phone = $request->phone;
        $editData->address = $request->address;
        
        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$editData->photo));
            $filename = date('YmdHI').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $editData['photo'] = $filename;
        }
        $editData->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function AdminPasswordChange()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_password_change', compact('profileData'));

    } // End Method

    public function AdminPasswordUpdate(Request $request)
    {
        //Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);           

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            $notification = array(
                'message' => 'Old Password does not match',
                'alert-type' => 'error'
            );
    
            return back()->with($notification);
        };

        // Update the New Password
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Updated Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    } // End Method


    //////////   Admin User Method ////////////
    public function AdminAll()
    {
        $admin_all = User::where('role', 'admin')->get();
        return view('backend.pages.admin.admin_all', compact('admin_all'));
        
    } // End Method

    public function AdminAdd()
    {
        $roles = Role::all();
        return view('backend.pages.admin.admin_add', compact('roles'));

    } // End Method

    public function AdminStore(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'Admin User Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all')->with($notification);

    } // End Method

    public function AdminEdit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('backend.pages.admin.admin_edit', compact('user', 'roles'));

    } // ENd Method

    public function AdminUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'Admin User Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all')->with($notification);

    } // ENd Method

    public function AdminDelete($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }
        $notification = array(
            'message' => 'Admin User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method





}
