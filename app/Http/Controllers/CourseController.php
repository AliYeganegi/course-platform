<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::searchResults()
            ->paginate(6);

        $breadcrumb = "Courses";

        return view('courses.index', compact(['courses', 'breadcrumb']));
    }

    public function addComment(Request $request, Course $course)
    {
        $request->validate(['content' => 'required']);
        $course->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);
        return back();
    }

    public function replyToComment(Request $request, Comment $comment)
    {
        $request->validate(['content' => 'required']);
        Comment::create([
            'user_id' => auth()->id(),
            'course_id' => $comment->course_id,
            'parent_id' => $comment->id,
            'content' => $request->content
        ]);
        return back();
    }

    public function likeComment(Comment $comment)
    {
        $comment->likes()->firstOrCreate(['user_id' => auth()->id()]);
        return back();
    }


    public function show(Course $course)
    {
        $course->load('institution');
        $breadcrumb = $course->name;

        return view('courses.show', compact(['course', 'breadcrumb']));
    }
}
