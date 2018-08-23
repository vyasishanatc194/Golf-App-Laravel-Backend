<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Review;
use App\Models\Course;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /*-------------------------------Get ReviewList-----------------------------------------*/

     public function getReviewListDetail(Request $request, $course_id){
        $reviewList = array();
        $data = array(
            'data' => $reviewList,
            'message' => 'reviewlist_detail_success',
            'status' => 200,
        );
        if($course_id){
            $course = \App\Models\Ext\Course::find($course_id);
            if(!empty($course)){
                $reviewList = Review::with('user')->select('reviews.id','reviews.user_id','reviews.title','reviews.description','created_at as date')
                                    ->where('course_id',$course_id)
                                    ->where('publish_flag',1)
                                    ->get();
                                   
                if(count($reviewList) > 0){
                    $data['data'] = $reviewList;
                }else{
                    $data['message'] = 'Review List Not Found';    
                }
             }else{
                $data['message'] = 'Course Not Found';    
            }
        }else{
            $data['message'] = 'Course Not Found';
        }
        return response()->json($data);
    }

    /*-------------------------------End Get ReviewList-------------------------------------------*/

    /*-------------------------------Post Review-----------------------------------------*/

    public function postReview(Request $request){
        $review = array();
        $data = array(
            'data' => $review,
            'message' => 'review_posted_success',
            'status' => 200,
        );
        
        $requestData = $request->all();
        $rules = array(
            'course_id'=>'required|integer',
            'user_id'=>'required|integer',
            'publish_flag'=>'required|in:0,1',
            'title' => 'required',
            'description' => 'required',
        );

        $url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = $_SERVER;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $contents = curl_exec($ch);
        curl_close($ch);
        
        $validator = \Validator::make($request->all(), $rules, []);
        if ($validator->fails()) {
            $msgArr = $validator->messages()->toArray();
            $data['message'] = reset($msgArr)[0];
        } else {
            $course = \App\Models\Ext\Course::find($requestData['course_id']);
            if(!empty($course)){                                
                $review = new Review;
                $review->course_id = $requestData['course_id'];
                $review->user_id = $requestData['user_id'];
                $review->publish_flag = $requestData['publish_flag'];
                $review->title = $requestData['title'];
                $review->description = $requestData['description'];
                $review->save();
                $data['data'] = $review;
            }else{
                $data['message'] = 'Course Not Found';    
            }
        }
        return response()->json($data);
    }

    /*-------------------------------End Post Review-------------------------------------------*/

}
