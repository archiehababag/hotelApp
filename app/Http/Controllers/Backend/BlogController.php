<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;
use App\Models\BlogPost;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BlogController extends Controller
{
    public function BlogCategory()
    {
        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category', compact('category'));

    } // End Method

    public function BlogCategoryStore(Request $request)
    {
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        $notification = array(
            'message' => 'Blog Category Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function BlogCategoryEdit($id)
    {
        $categories = BlogCategory::find($id);

        return response()->json($categories);

    } // End Method

    public function BlogCategoryUpdate(Request $request)
    {
        $category_id = $request->cat_id;

        BlogCategory::find($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function BlogCategoryDelete($id)
    {
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method






    /******************* ********** **********************/
    /******************* Blog Posts **********************/
    /******************* ********** **********************/


    public function BlogPostAll()
    {
        $blog_post = BlogPost::latest()->get();

        return view('backend.post.blog_post_all', compact('blog_post'));

    } // End Method

    public function BlogPostAdd()
    {
        $categories = BlogCategory::latest()->get();
        return view('backend.post.blog_post_add', compact('categories'));

    } //ENd Method

    public function BlogPostStore(Request $request)
    {
        $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(550,370)->save('upload/blog_post_images/'.$name_gen);
        $save_url = 'upload/blog_post_images/'.$name_gen;

        BlogPost::insert([
            'blog_category_id' => $request->blog_category_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog Post Data Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('blog.post.all')->with($notification);

    } // End Method

    public function BlogPostEdit($id)
    {
        $blog_post_edit = BlogPost::find($id);
        $categories = BlogCategory::latest()->get();

        return view('backend.post.blog_post_edit', compact('blog_post_edit', 'categories'));

    } // End Method

    public function BlogPostUpdate(Request $request)
    {
        $blog_post_id = $request->id;

        if ($request->file('post_image')) {

            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(550,370)->save('upload/blog_post_images/'.$name_gen);
            $save_url = 'upload/blog_post_images/'.$name_gen;

            BlogPost::findOrFail($blog_post_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Blog Post Data with New Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('blog.post.all')->with($notification);

        } else {

            BlogPost::findOrFail($blog_post_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Blog Post Data without Image Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('blog.post.all')->with($notification);
        }

    } // End Method

    public function BlogPostDelete($id)
    {
        $item = BlogPost::findOrFail($id);
        $image = $item->post_image;
        unlink($image);

        BlogPost::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Post Data Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    } // End Method


    /******************* **** No Auth ****** **********************/
    /******************* Frontend Blog Posts **********************/
    /******************* ***** No Auth ***** **********************/


    public function BlogDetails($slug)
    {
        $blog_post = BlogPost::where('post_slug', $slug)->first();
        $blog_category = BlogCategory::latest()->get();
        $latest_post = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_details', compact('blog_post', 'blog_category', 'latest_post'));

    } //End Method

    public function BlogCategoryList($id)
    {
        $blog_post = BlogPost::where('blog_category_id', $id)->get();
        $category_name = BlogCategory::where('id', $id)->first();
        $blog_category = BlogCategory::latest()->get();
        $latest_post = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_category_list', compact('blog_post', 'blog_category', 'latest_post', 'category_name'));

    } //End Method

    public function BlogList()
    {
        $blog_post = BlogPost::latest()->paginate(3);
        $blog_category = BlogCategory::latest()->get();
        $latest_post = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_all', compact('blog_post', 'blog_category', 'latest_post'));


    } // End Method





}
