<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoomType;
use App\Models\Room;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class RoomTypeController extends Controller
{
    public function RoomTypeList()
    {
        $allRoomType = RoomType::orderBy('id', 'desc')->get();

        return view('backend.allroom.roomtype.roomtype_view', compact('allRoomType'));

    } // End Method

    public function RoomTypeAdd()
    {
        return view('backend.allroom.roomtype.roomtype_add');

    } // End Method

    public function RoomTypeStore(Request $request)
    {
        $room_type_id = RoomType::insertGetId([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        Room::insert([
            'room_type_id' => $room_type_id,
        ]);

        $notification = array(
            'message' => 'Room Type Stored Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('room.type.list')->with($notification);

    } // End Method



    
    
}
