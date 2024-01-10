<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Team;
use App\Models\BookArea;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class TeamController extends Controller
{

    public function TeamAll() 
    {
        $team = Team::latest()->get();

        return view('backend.team.team_all', compact('team'));

    } // End Method

    public function TeamAdd()
    {
        return view('backend.team.team_add');
        
    } // End Method

    public function TeamStore(Request $request)
    {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550,670)->save('upload/team_images/'.$name_gen);
        $save_url = 'upload/team_images/'.$name_gen;

        Team::insert([
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Team Member Data Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('team.all')->with($notification);

    } // End Method

    public function TeamEdit($id)
    {
        $team = Team::findOrFail($id);  

        return view('backend.team.team_edit', compact('team'));

    } // End Method

    public function TeamUpdate(Request $request)
    {
        $team_id = $request->id;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550,670)->save('upload/team_images/'.$name_gen);
            $save_url = 'upload/team_images/'.$name_gen;

            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Team Member Data with New Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('team.all')->with($notification);

        } else {

            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Team Member Data without Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('team.all')->with($notification);

        }
        

    } // End Method

    public function TeamDelete($id)
    {   
        $item = Team::findOrFail($id);
        $image = $item->image;
        unlink($image);

        Team::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Team Member Data Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method


    
    /** ======================= BOOKING AREA METHODS =============================== */


    public function TeamBookingAreaEdit()
    {
        $book = BookArea::find(1);
        return view('backend.bookarea.book_area_edit', compact('book'));

    } // End Method

 
    public function TeamBookingAreaUpdate(Request $request)
    {
        $book_id = $request->id;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1000,1000)->save('upload/book_area_images/'.$name_gen);
            $save_url = 'upload/book_area_images/'.$name_gen;

            BookArea::findOrFail($book_id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_description' => $request->short_description,
                'link_url' => $request->link_url,
                'image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Booking Area Data with New Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('team.booking.area.edit')->with($notification);

        } else {

            BookArea::findOrFail($book_id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_description' => $request->short_description,
                'link_url' => $request->link_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Booking Area Data without Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('team.booking.area.edit')->with($notification);
        }

    } // End Method





}
