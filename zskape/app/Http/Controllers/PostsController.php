<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\PostRequest;
use App\Post;
use App\PostRating;
use App\User;
use App\PostReport;
use File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    /*
     *
     */
    public function get_posts_search(Request $request)
    {

        if (Input::has('search')) {
            $search = Input::get('search');
            $posts = Post::where('title', 'LIKE', '%' . $search . '%')->paginate(150);
            // returns a view and passes the view the list of articles and the original query.
            return view('frontpage', compact('posts', 'search'));
        } else {
            abort(404);
        }


    }

    /**
     * Display a listing of the post resource sortet by newest.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_posts_newest()
    {
        $posts = Post::all()->orderBy('created_at', 'desc')->paginate(55);
        return view('frontpage', compact('posts'));
    }

    /**
     *  Display a listing of the specifc user post resource sortet by newest.
     *
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_posts_by_user_newest($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        $posts = $user->post()->orderBy('created_at', 'desc')->paginate(150);
        // Get all the comments on posts and order by created_at
        return view('home', compact('posts', 'user'));
    }


    /**
     * Display a listing of post resource sortet by trending (weighted_wilson). /Frontpage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_posts_trending()
    {

        // How many posts should be displayed on each page
        $perPage = 150;

        // Get the current page
        $currentPage = Input::get('page');

        // Check if current page isset or else give it the number 1
        if(!isset($currentPage)) {
            $currentPage = 1;
        }

        // Check if current page is numberic else throw erro. All pages is numeric
        if(!is_numeric($currentPage)) {
            abort(404);
        }

        // Calculate offset
        $offset = ($currentPage * $perPage) - $perPage;

        // Get count of all posts
        $countAll = Post::all()->count();

        // Calculate how many pages there will be and what number lastpage is going to be
        $lastpage = ($countAll / $perPage);

        // if lastpage is lower than current page then just throw error. page dosnt exists
        if(ceil($lastpage) < $currentPage)
        {
            abort(404);
        }

        // Raw Wilson Score SQL - Trending Posts
        $rawSQL = "SELECT  posts.up, posts.down, posts.created_at, posts.created_at, posts.title, posts.id, posts.file_thumb, posts.file_extension,  posts.rating, users.name,
                (((posts.up + 1.9208) / (posts.up + posts.down) - 1.96 * SQRT((posts.up * posts.down) / (posts.up + posts.down) + 0.9604) / (posts.up + posts.down)) / (1 + 3.8416 / (posts.up + posts.down))) AS wilson,
                ((((posts.up + 1.9208) / (posts.up + posts.down) - 1.96 * SQRT((posts.up * posts.down) / (posts.up + posts.down) + 0.9604) / (posts.up + posts.down)) / (1 + 3.8416 / (posts.up + posts.down))) / LN(DATEDIFF(NOW(), posts.created_at) + EXP(0.3))) AS weighted_wilson
                FROM posts
                INNER JOIN users
                ON posts.user_id = users.id
                ORDER BY weighted_wilson DESC
                LIMIT $offset, $perPage";

        // GET alle the trending posts
        $posts = DB::select(DB::raw($rawSQL));

        // If no results then display a 404 error page


        // Make a new Paginationer object
        $posts = new LengthAwarePaginator($posts, $countAll, $perPage, $currentPage);
        // return pagination objecter and display the results
        return view('frontpage', compact('posts'));
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Upload resource image
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {

        if (!Auth::check())
        {
            return redirect('/auth/login')->with('flash_message', array('warning', 'Please log in to upload.'));
        }
        // all inputs
        $input = $request->all();

        // Get Image from inputs
        $file = $input['file'];

        // Filename renames to a random 10 characters string
        $fileName = str_random(10);

        $title = $input['title'];

        // Image Mime
        $mime = $file->getMimeType();

        // Image extension
        $extension = $file->getClientOriginalExtension();

        // Check if filename exists and create a new name for the file
        $n = 1;
        while (File::exists('i/' . $fileName . "." . $extension))
        {
            $fileName = str_random(10);
            $n++;
        }

        // Add extension til filename
        $fileThumbnail = $fileName . "Z";
        // Set save path for thumbnails
        $fileThumbPath = 'i/' . $fileThumbnail . "." . $extension;
        // create transparent background color for thumbnails
        // $background = Image::canvas(218, 218, "#FFFFFF");
        // make a new image object
        $imgThumbnail = Image::make($file->getRealPath())->fit(200, 200, function ($c)
        {
            $c->aspectRatio();
        })->save($fileThumbPath);

        // Set save path for image
        $filePath = 'i/';
        // Upload big image
        $fileUpload = $request->file('file')->move($filePath, $fileName . "." . $extension);


        // If upload success then insert into db
        if ($imgThumbnail && $fileUpload)
        {

            $post = new Post(array(
                'id' => $fileName,
                'title' => $title,
                'file_thumb' => $fileThumbnail,
                'file_extension' => $extension,
                'file_mime' => $mime,


            ));

            // save data with user
            Auth::user()->post()->save($post);

            // redirect with message
            return redirect('/'.$fileName)->with('flash_message', array('success', "File have been successful uploaded and your post '".str_limit($title, $limit = 100, $end = '...') ."' have been created"));
        } else {
            // redirect with error message
            return redirect('/')->with('flash_message', array('error', "Something went wrong"));
        }

    }


    /**
     * User vote on resource
     *
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rate_posts_by_users(Request $request, $post_id)
    {

        if (!Auth::check()) {
            return redirect('/auth/login')->with('flash_message', array('warning', 'Login to vote.'));
        }
        $vote = Input::get('vote');

        if (($vote == 0) or ($vote == 1)) {

            // check if post exists
            $postExists = Post::where('id', $post_id)->first();

            // posts exists
            if($postExists) {

            // Try and get recors from db to see if user have rated the post before
            $isRated = PostRating::where('post_id', $postExists->user_id)->where('user_id', Auth::user()->id)->get();

            // if no results then lets rate the post :)
            if ($isRated->isEmpty()) {

                // Create a new PostRating object
                $rating = new PostRating;
                $rating->voted = $vote;
                $rating->post_id = $postExists->id;
                // save data with user
                $ratingSaved = Auth::user()->postsRatings()->save($rating);

                // If upvote then increment points
                if (($ratingSaved) && ($vote == 1)) {
                        Post::where('id', $postExists->id)
                        ->update([
                            'rating' => DB::raw('rating + 1'),
                            'up' => DB::raw('up + 1')
                        ]);
                        // Update user points by increment for upvote
                        User::where('id', $postExists->user_id)->increment('points');
                    // If downvote then decrement points
                } elseif (($ratingSaved) && ($vote == 0)) {
                        Post::where('id', $postExists->id)
                        ->update([
                            'rating' => DB::raw('rating - 1'),
                            'down' => DB::raw('down + 1')
                        ]);

                        // Update user points by decrement for downvotes
                        User::where('id', $postExists->user_id)->decrement('points');

                }
                return redirect()->back()->with('flash_message', array('success', "Your vote have been added."));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
        }
    }


    public function post_report(Request $request, $post_id) {
        if (!Auth::check()) {
            return redirect('/auth/login')->with('flash_message', array('warning', 'Login to report this post.'));
        }

        // Try and get recors from db to see if user have rated the post before
        $isReported = PostReport::where('post_id', $post_id)->where('user_id', Auth::user()->id)->get();

        if ($isReported->isEmpty()) {

            // Create a new PostRating object
            $report= new PostReport;
            $report->post_id = $post_id;
            // save data with user
            $reportSaved = Auth::user()->postsReports()->save($report);
            if ($reportSaved) {
                return redirect()->back()->with('flash_message', array('success', "You have reported this post. Thanks for helping making zskape a better place."));
            } else {
                return redirect()->back()->with('flash_message', array('error', "Something went wrong"));
            }

        } else {
            return redirect()->back()->with('flash_message', array('error', "You have already voted on this post"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Id is 10 lenght everything else is not correct id!
        if(strlen($id) !== 10) {
            abort(404);
        }
        // Get post
        // $post = Post::with('comments')->findOrFail($id);

        $post = Post::where('id', $id)->first();

        $posts = Post::orderBy(DB::raw('RAND()'))->where('id', '!=' , $id)->take(10)->get();


        $comments = Comment::where('post_id', $id)
                    ->leftJoin('comment_files', 'comment_files.comment_id', '=', 'comments.id')
                    ->orderBy('created_at', 'ASC')
                    ->get();

        // Get all the comments on posts and order by created_at
        // $comments = $post->comments()->get();

        if (!$post) {
            abort(404);
        }


        // check if user is logged in
        if (Auth::check()) {


            // Check if user have reporte the post
            $isReported = PostReport::where('post_id', $id)->where('user_id', Auth::user()->id)->value('id');

            if($isReported == null) {
                $isReported = 'false';
            }


            // check if user have rated the post before
            $isRated = PostRating::where('post_id', $id)->where('user_id', Auth::user()->id)->value('voted');





            // null if not rated before
            if (($isRated == 0) or ($isRated == 1)) {
                return view('posts.show', compact('post', 'isRated', 'isReported', 'comments', 'posts'));
            } elseif ($isRated == null) {
                $isRated = 2;
                return view('posts.show', compact('post', 'isRated', 'isReported', 'comments', 'posts'));
            }

        }
        $isReported = 'false';
        $isRated = 2;
        return view('posts.show', compact('post', 'isRated', 'isReported', 'comments', 'posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {

        // Id is 10 lenght everything else is not correct id!
        // User have to be logged ind to delete
        if ((!Auth::check()) && (strlen($id) !== 10)) {
            abort(404);
        }
        //find id by slug
        $post = Post::findOrFail($id);
        // check to see if user is owner of the post
        if (($post && Auth::user()->id == $post->user_id) || ($post && Auth::user()->role == 1)) {

                // Path to image and thumb files
                $pathToImage = 'i/' . $post->id . "." . $post->file_extension;
                $pathToThumb = 'i/' . $post->file_thumb . "." . $post->file_extension;


                $comments = Comment::where('post_id', $id)
                    ->leftJoin('comment_files', 'comment_files.comment_id', '=', 'comments.id')
                    ->get();



                if($comments) {
                    foreach($comments as $file) {
                        File::delete('i/' . $file->file . "." . $file->file_extension);
                        File::delete('i/' . $file->file_thumb . "." . $file->file_extension);
                    }
                }

                // Deleting the Images files
                $filesDeleted = File::delete($pathToImage, $pathToThumb);
                // If Image files got deleted then delete db post info
                if ($filesDeleted) {
                    $post->delete();
                    return Redirect::back()->with('flash_message', array('delete', 'Post "' . str_limit($post->title, $limit = 100, $end = '...') . '" have been succesful deleted'));

                } else {
                    return Redirect::back()->with('flash_message', array('error', 'Something went wrong with deleting the Image files'));
                }

        }
        abort(404, 'error');
    }


}
