<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentFile;
use App\CommentReply;
use App\CommentReport;
use App\Post;
use File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

class CommentsController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request CommentRequest $request
     * @return \Illuminate\Http\Response
     */




    public function store(CommentRequest $request, $post_id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login')->with('flash_message', array('warning', "Please log in to make a comment."));
        }

        // post length is 10 else post dosnt exists !
        if (strlen($post_id) !== 10) {
            abort(404);
        }

        // check if post exists
        $post = Post::where('id', $post_id)->first();

        // else error page
        if (!$post) {
            abort(404);
        }
        // all inputs
        $input = $request->all();

        // check if comment got a file
        if (isset($input['file'])) {
            // Get Image from inputs
            $file = $input['file'];

            // Filename renames to a random 10 characters string
            $fileName = str_random(12);

            // Image Mime
            $mime = $file->getMimeType();

            // Image extension
            $extension = $file->getClientOriginalExtension();

            // Check if filename exists and create a new name for the file
            $n = 1;
            while (File::exists('i/' . $fileName . "." . $extension)) {
                $fileName = str_random(12);
                $n++;
            }

            // Add extension til filename
            $fileThumbnail = $fileName . "C";
            // Set save path for thumbnails
            $fileThumbPath = 'i/' . $fileThumbnail . "." . $extension;
            // create transparent background color for thumbnails
            // $background = Image::canvas(218, 218, "#FFFFFF");
            // make a new image object
            $imgThumbnail = Image::make($file->getRealPath())->resize(125, 150, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($fileThumbPath);


            // Set save path for image
            $filePath = 'i/';
            // Upload big image
            $fileUpload = $request->file('file')->move($filePath, $fileName . "." . $extension);


            // If upload success then insert into db
            if ($fileUpload && $imgThumbnail) {

                if (isset($input['reply'])) {
                    $ReplyID = $input['reply'];
                    $commentExists = Comment::where('id', $ReplyID)->first();

                        if($commentExists) {
                            // if posts exist make a new comment object
                            $comment = new Comment;

                            // add text
                            $comment->text = $request->text;

                            $comment->parent_id = $commentExists->id;
                            // set relationshop with post and comments
                            $comment->post_id = $post_id;

                            // save data with user
                            $commentSaved = Auth::user()->comments()->save($comment);

                            if ($commentSaved) {

                                $commentFile = new CommentFile(array(
                                    'comment_id' => $commentSaved->id,
                                    'file' => $fileName,
                                    'file_thumb' => $fileThumbnail,
                                    'file_mime' => $mime,
                                    'file_extension' => $extension
                                ));

                                $commentFile->save();
                                // redirect with message
                                return redirect($post_id)->with('flash_message', array('success', 'Comment have been succesful created'));
                            }
                        }
                } else {

                // if posts exist make a new comment object
                $comment = new Comment;

                // add text
                $comment->text = $request->text;

                // set relationshop with post and comments
                $comment->post_id = $post_id;

                // save data with user
                $commentSaved = Auth::user()->comments()->save($comment);

                if ($commentSaved) {

                    $commentFile = new CommentFile(array(
                        'comment_id' => $commentSaved->id,
                        'file' => $fileName,
                        'file_thumb' => $fileThumbnail,
                        'file_mime' => $mime,
                        'file_extension' => $extension
                    ));

                    $commentFile->save();
                    // redirect with message
                    return redirect($post_id)->with('flash_message', array('success', 'Comment have been succesful created'));
                }


                }
            }
        }


        if (isset($input['reply'])) {
            $ReplyID = $input['reply'];
            $commentExists = Comment::where('id', $ReplyID)->first();
            if ($commentExists) {
                // if posts exist make a new comment object
                $comment = new Comment;

                // add text
                $comment->text = $request->text;

                $comment->parent_id = $commentExists->id;
                // set relationshop with post and comments
                $comment->post_id = $post_id;

                Auth::user()->comments()->save($comment);

                // return with message
                return redirect($post_id)->with('flash_message', array('success', 'Comment have been succesful created'));
            }

            } else {

                // if posts exist make a new comment object
                $comment = new Comment;
                // add text
                $comment->text = $request->text;
                // set relationshop with post and comments
                $comment->post_id = $post_id;

                // save data with user
                Auth::user()->comments()->save($comment);

                // return with message
                return redirect($post_id)->with('flash_message', array('success', 'Comment have been succesful created'));
            }
        }


    public function comment_reply(CommentRequest $request, $comment_id)
    {


    }

    public function comment_report(Request $request, $comment_id)
    {
        if (!Auth::check()) {
            return redirect('/auth/login')->with('flash_message', array('warning', 'Login to report this Comment.'));
        }

        // Try and get recors from db to see if user have rated the post before
        $isReported = CommentReport::where('comment_id', $comment_id)->where('user_id', Auth::user()->id)->get();

        if ($isReported->isEmpty()) {

            // Create a new PostRating object
            $report = new CommentReport;
            $report->comment_id = $comment_id;
            // save data with user
            $reportSaved = Auth::user()->commentsReports()->save($report);
            if ($reportSaved) {
                return redirect()->back()->with('flash_message', array('success', "You have reported this comment. Thanks for helping making zskape a better place."));
            } else {
                return redirect()->back()->with('flash_message', array('error', "Something went wrong"));
            }
        } else {
            return redirect()->back()->with('flash_message', array('error', "You have already repoted this comment"));
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            abort(404);
        }

        // Id is 10 lenght everything else is not correct id!
        if (strlen($id) > 10) {
            abort(404);
        }
        //find id by slug
        $comment = Comment::findOrFail($id);
        if ($comment) {
            $commentfiles = CommentFile::where('comment_id', $id)->first();
            if (($comment && Auth::user()->id == $comment->user_id) || ($comment && Auth::user()->role == 1)) {
                // check ande delete if the comments have reports
                CommentReport::where('comment_id', $comment->id)->delete();
                // check if there is a file
                if ($commentfiles !== null) {

                    // Path to image and thumb files
                    $pathToImage = 'i/' . $commentfiles['file'] . "." . $commentfiles['file_extension'];
                    $pathToThumb = 'i/' . $commentfiles['file_thumb'] . "." . $commentfiles['file_extension'];
                    // Deleting the Images files
                    $filesDeleted = File::delete($pathToImage, $pathToThumb);
                    // If Image files got deleted then delete db post info
                    if ($filesDeleted) {
                        $commentfiles->where('comment_id', $comment->id)->delete();
                        $comment->update(['text' => 'Comment have been deleted', 'active' => 0]);

                        return Redirect::back()->with('flash_message', array('delete', 'Comment "' . str_limit($comment->text, $limit = 100, $end = '...') . '" have been succesful deleted'));
                    } else {
                        return Redirect::back()->with('flash_message', array('error', 'Something went wrong with deleting the Image files'));
                    }
                } else {

                    $comment->update(['text' => 'Comment have been deleted', 'active' => 0]);
                    return Redirect::back()->with('flash_message', array('delete', 'Comment "' . str_limit($comment->text, $limit = 100, $end = '...') . '" have been succesful been deleted'));
                }
            } else {
                abort(404, 'error');
            }
        } else {
            abort(404, 'error');
        }
        abort(404, 'error');
    }
}
