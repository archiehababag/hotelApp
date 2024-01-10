<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogPost;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CommentController extends Controller
{
    public function CommentStore(Request $request)
    {
        Comment::insert([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Blog Comment Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    } // End Method



     /******************* ********** **********************/
    /**************** Auth Admin Routes *******************/
    /******************* ********** **********************/
    public function CommentAll()
    {
        $all_comments = Comment::latest()->get();

        return view('backend.comment.comment_all', compact('all_comments'));

    }

    public function UpdateCommentStatus(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $is_checked = $request->input('is_checked', 0);

        $comment = Comment::find($comment_id);
        if ($comment) {
            $comment->status = $is_checked;
            $comment->save();
        }

        return response()->json(['message' => 'Comment Status Updated Successfully']);

    } // End Method



}
