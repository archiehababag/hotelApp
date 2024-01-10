<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function Index()
    {
        return view('frontend.index');

    } // End Method

    public function UserProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('profileData'));

    } // End Method

    public function UserProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $editData = User::find($id);
        $editData->name = $request->name;
        $editData->email = $request->email;
        $editData->phone = $request->phone;
        $editData->address = $request->address;
        
        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$editData->photo));
            $filename = date('YmdHI').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $editData['photo'] = $filename;
        }
        $editData->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logged Out Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);

    } // End Method

    public function UserPasswordChange()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('frontend.dashboard.user_password_change', compact('profileData'));

    } // End Method

    public function UserPasswordUpdate(Request $request)
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





}
