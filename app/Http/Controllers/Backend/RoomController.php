<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\RoomNumber;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function RoomEdit($id) 
    {
        $basic_facility = Facility::where('room_id', $id)->get();
        $multiImages = MultiImage::where('room_id', $id)->get();
        $roomNumbers = RoomNumber::where('room_id', $id)->get();
        $editData = Room::findOrFail($id);

        return view('backend.allroom.room.room_edit', compact('editData', 'basic_facility', 'multiImages', 'roomNumbers'));

    } // End Method

    public function RoomUpdate(Request $request, $id)
    {
        $room = Room::find($id);

        $room->room_type_id = $room->room_type_id;
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;
        
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->discount = $request->discount;
        $room->short_description = $request->short_description;
        $room->description = $request->description;
        $room->status = 1;

        //* Update Single/Main Image *//
        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550,850)->save('upload/room_images/'.$name_gen);
            $room['image'] = $name_gen;
        }

        $room->save();


        //* Update For Facility Table *//
        if ($request->facility_name == NULL) {

            $notification = array(
                'message' => 'Please Select Basic Facilities',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);

        } else {

            Facility::where('room_id', $id)->delete();
            $facilities = Count($request->facility_name);
            for ($i=0; $i < $facilities; $i++) { 
                $fcount = new Facility();
                $fcount->room_id = $room->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            }
        }

        //* Update For Multi Image Table *//
        if ($room->save()) {
            $files = $request->multi_image;
            if (!empty($files)) {
                $subImage = MultiImage::where('room_id', $id)->get()->toArray();
                MultiImage::where('room_id', $id)->delete();
            }
            
            if(!empty($files)) {
                foreach ($files as $file) {
                    $imgName = date('YmdHi').$file->getClientOriginalName();
                    $file->move('upload/room_images/multi_images/', $imgName);
                    $subImage['multi_image'] = $imgName;

                    $subImage = new MultiImage();
                    $subImage->room_id = $room->id;
                    $subImage->multi_image = $imgName;
                    $subImage->save();
                }
            }
        } // end if

        $notification = array(
            'message' => 'Room Information Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function MultiImageDelete($id)
    {
        $deleteData = MultiImage::where('id', $id)->first();

        if ($deleteData) {
            $imagePath = $deleteData->multi_image;
            
            //Check if File exists before Unlinking
            if (file_exists($imagePath)) {
                @unlink($imagePath);
                echo "Image Unlinked Successfully";
            } else {
                echo "Image not found on file";
            }
            
            // Delete Record from Database
            MultiImage::where('id', $id)->delete();

        }

        $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function RoomNumberStore(Request $request, $id)
    {
        $data = new RoomNumber();
        $data->room_id = $id;
        $data->room_type_id = $request->room_type_id;
        $data->room_no = $request->room_no;
        $data->status = $request->status;
        $data->save();

        $notification = array(
            'message' => 'Room Number Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function RoomNumberEdit($id)
    {
        $editRoomNumber = RoomNumber::find($id);
        return view('backend.allroom.room.room_number_edit', compact('editRoomNumber'));

    } // End Method

    public function RoomNumberUpdate(Request $request, $id)
    {
        $roomNumber = RoomNumber::find($id);
        $roomNumber->room_no = $request->room_no;
        $roomNumber->status = $request->status;
        $roomNumber->save();

        $notification = array(
            'message' => 'Room Number Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);

    } // End Method

    public function RoomNumberDelete($id)
    {
        RoomNumber::find($id)->delete();

        $notification = array(
            'message' => 'Room Number Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);

    } // End Method

    public function RoomDelete(Request $request, $id)
    {
        $room = Room::find($id);

        if (file_exists('upload/room_images/'.$room->image) AND ! empty($room->image)) {
           @unlink('upload/room_images/'.$room->image);
        }

        $subImage = MultiImage::where('room_id', $room->id)->get()->toArray();
        if (!empty($subImage)) {
            foreach ($subImage as $value) {
                if ($value) {
                    @unlink('upload/room_images/multi_images/'.$value['multi_image']);
                }
            }
        }

        RoomType::where('id', $room->room_type_id)->delete();
        MultiImage::where('room_id', $room->id)->delete();
        Facility::where('room_id', $room->id)->delete();
        RoomNumber::where('room_id', $room->id)->delete();
        $room->delete();

        $notification = array(
            'message' => 'Room Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    
    


}
