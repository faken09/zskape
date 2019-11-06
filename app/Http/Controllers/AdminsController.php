<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReport;
use App\Post;
use App\PostReport;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminsController extends Controller
{

    public function __construct()
    {
        // user have to be login to use this page
        $this->middleware('auth');
        // check if user have admin role = 1 ??
        if(Auth::check() && Auth::user()->role != 1){
            // else abort mission !!!!!!!!!!
            abort(404);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // post with reports get
        $posts = Post::has('postsReports')->get();

        // comments with reports get
        $comments = Comment::has('commentsReports')->leftJoin('comment_files', 'comment_files.comment_id', '=', 'comments.id')->get();

        return view('admin.index', compact('posts', 'comments'));
    }

    // remove reports on post
    public function post_reports_destroy($id)
    {
        $reports = PostReport::where('post_id', $id)->get();
        if($reports) {
            foreach($reports as $report) {
                $report->delete();
            }
            return Redirect::back()->with('flash_message', array('delete', 'Reports on post have been deleted'));
        } else {
            return Redirect::back()->with('flash_message', array('error', 'There was no reports on post. Maybe post got deleted'));
        }

    }

    // remove reports on comment
    public function comment_reports_destroy($id)
    {
        $reports = CommentReport::where('comment_id', $id)->get();
        if($reports) {
            foreach($reports as $report) {
                $report->delete();
            }
            return Redirect::back()->with('flash_message', array('delete', 'Reports on comment have been deleted'));
        } else {
            return Redirect::back()->with('flash_message', array('error', 'There was no reports on comment. Maybe post got deleted'));
        }

    }

}
