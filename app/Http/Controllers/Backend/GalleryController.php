<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Gallery;
use App\Models\Contact;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class GalleryController extends Controller
{
    public function GalleryAll()
    {
        $gallery = Gallery::latest()->get();

        return view('backend.gallery.gallery_all', compact('gallery'));

    } // End Method

    public function GalleryAdd()
    {
        return view('backend.gallery.gallery_add');

    } // End Method

    public function GalleryStore(Request $request)
    {
        $images = $request->file('photo_name');

        foreach ($images as $image) {
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550,550)->save('upload/gallery_images/'.$name_gen);
            $save_url = 'upload/gallery_images/'.$name_gen;

            Gallery::insert([
                'photo_name' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Gallery Image Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('gallery.all')->with($notification);


    } // End Method

    public function GalleryEdit($id)
    {
        $gallery = Gallery::find($id);

        return view('backend.gallery.gallery_edit', compact('gallery'));

    } // End Method

    public function GalleryUpdate(Request $request)
    {
        $gallery_id = $request->id;
        $image = $request->file('photo_name');

        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550,550)->save('upload/gallery_images/'.$name_gen);
        $save_url = 'upload/gallery_images/'.$name_gen;

        Gallery::find($gallery_id)->update([
            'photo_name' => $save_url,
            'updated_at' => Carbon::now(),
        ]);
    
        $notification = array(
            'message' => 'Gallery Image Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('gallery.all')->with($notification);


    } // End Method

    public function GalleryDelete($id)
    {
        $gallery = Gallery::find($id);
        $image = $gallery->photo_name;
        unlink($image);

        Gallery::find($id)->delete();

        $notification = array(
            'message' => 'Gallery Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('gallery.all')->with($notification);

    } //End Method

    public function GalleryMultipleDelete(Request $request)
    {
        $selectedItems = $request->input('selectedItem', []);

        foreach ($selectedItems as $itemId) {
            $item = Gallery::find($itemId);
            $image = $item->photo_name;
            unlink($image);

            $item->delete();
        }

        $notification = array(
            'message' => 'Selected Gallery Images Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('gallery.all')->with($notification);

    } // End Method

    
     /**************** Frontend Gallery Methods *******************/
    public function GalleryShow()
    {
        $gallery = Gallery::latest()->get();

        return view('frontend.gallery.gallery_show', compact('gallery'));

    } // End Method


     /**************** Frontend Contact Us Methods *******************/
    public function ContactDetails()
    {
        return view('frontend.contact.contact_details');

    } //End Method

    public function ContactStore(Request $request)
    {
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Your Message was Sent Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('contact.details')->with($notification);

    } //End Method


     /**************** Admin Auth Contact Us Methods *******************/
    public function AdminContactMessage()
    {
        $contact = Contact::latest()->get();

        return view('backend.contact.contact_message', compact('contact'));

    } // End Method
 

}
