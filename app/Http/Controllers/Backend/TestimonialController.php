<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class TestimonialController extends Controller
{
    public function TestimonialAll()
    {
        $testimonial = Testimonial::latest()->get();

        return view('backend.testimonial.testimonial_all', compact('testimonial'));

    } // End Method

    public function TestimonialAdd()
    {
        return view('backend.testimonial.testimonial_add');

    } // End Method

    public function TestimonialStore(Request $request)
    {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(50,50)->save('upload/testimonial_images/'.$name_gen);
        $save_url = 'upload/testimonial_images/'.$name_gen;

        Testimonial::insert([
            'name' => $request->name,
            'city' => $request->city,
            'message' => $request->message,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Testimonial Data Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('testimonial.all')->with($notification);


    } // End Method

    public function TestimonialEdit($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return view('backend.testimonial.testimonial_edit', compact('testimonial'));

    } // End Method

    public function TestimonialUpdate(Request $request)
    {
        $testimonial_id = $request->id;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(50,50)->save('upload/testimonial_images/'.$name_gen);
            $save_url = 'upload/testimonial_images/'.$name_gen;

            Testimonial::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Testimonial Data with New Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('testimonial.all')->with($notification);

        } else {

            Testimonial::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Testimonial Data without Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('testimonial.all')->with($notification);
        }

    } // End Method

    public function TestimonialDelete($id)
    {   
        $item = Testimonial::findOrFail($id);
        $image = $item->image;
        unlink($image);

        Testimonial::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Testimonial Data Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method






}
