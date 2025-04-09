<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function like(Comment $comment)
    {
        $comment->likes()->toggle(auth()->user()->id);
        return back();
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new Comment();
        $reply->user_id = auth()->user()->id;
        $reply->course_id = $comment->course_id;
        $reply->content = $request->content;
        $reply->parent_id = $comment->id;
        $reply->save();

        return back();
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }
}
