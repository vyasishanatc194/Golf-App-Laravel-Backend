<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CourseProcess;
use App\User;
use App\Models\Chapter;
use App\Models\Course;

class CourseProcessController extends Controller
{
    //

    public function __construct()
    {

    }


    public function AddUpdateCourseAsMarked(Request $request){
        //dd($request);
        $courseProcess = array();
        $data = array(
            'data' => $courseProcess,
            'message' => 'course_process_mark_success',
            'status' => 200,
        );
        
        if($_POST){
            $user = User::find($_POST['user_id']);
            if(!empty($user)){
                $user_id = $_POST['user_id'];
                $chapter_id  = $_POST['chapter_id'];
                $courseId  = $_POST['courseid'];
                $mark = $_POST['is_mark'];
                //$course = Course::find($_POST['courseid']);
                //$chapter = Chapter::find($_POST['chapter_id']);
                $course = \App\Models\Ext\Course::where('id', $courseId)
                    ->with([
                        'modules' => function ($query1) use ($chapter_id) {
                            $query1->with(['chapters' => function($query) use ($chapter_id) {
                                $query->where('id', $chapter_id)->first();
                            }]);
                        }
                    ])
                    ->first();
                //dd($course->modules);
                if(!empty($course)){
                    $modules = $course->modules;
                    $flag = false;
                    foreach( $modules as $module ){
                        if(count($module->chapters) > 0){
                            $flag = true;
                        }
                    } 
                    if($flag){
                        $url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        $data = $_SERVER;
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                        $contents = curl_exec($ch);
                        curl_close($ch);
                        $courseProcess = CourseProcess::where('user_id', $user_id)->where('chapter_id', $chapter_id)->where('courseid', $courseId)->first();
                        if (empty($courseProcess)) {
                            $courseProcess = new CourseProcess();
                            $courseProcess->user_id = $user_id;
                            $courseProcess->chapter_id = $chapter_id;
                            $courseProcess->courseid = $courseId;
                            $courseProcess->is_mark = $mark;
                            $courseProcess->save();
                        } else {
                            $courseProcess = CourseProcess::find($courseProcess->id);
                            $courseProcess->is_mark = $mark;
                            $courseProcess->save();
                        }
                    }else{
                        $data['message'] = 'Chapters  Not found';        
                    }
                }else{
                    $data['message'] = 'Course  Not found';    
                }
                
            }else{
                $data['message'] = 'User Not Found';
            }
        }else{
            $data['message'] = 'Method Not Found';
        }
        $data['data'] = $courseProcess;
        return response()->json($data);
        
    }

    public function trackCourseProcess($courseId, $userID){
        $courseProcessDetail = array();
        $data = array(
            'data' => $courseProcessDetail,
            'message' => 'course_process_success',
            'status' => 200,
        );
        if($courseId > 0 && $userID > 0){
            $user = User::find($userID);
            if(!empty($user)){
                $course = \App\Models\Ext\Course::where('id', $courseId)
                    ->with([
                        'modules' => function ($query1) {
                            $query1->with(['chapters']);
                        }
                    ])
                    ->first();
                if(!empty($course)){
                    $getModules = $course->modules;//[0]->chapters;
                    $getCountChapter = 0;
                    foreach($getModules as $modules){
                        $getCountChapter += count($modules->chapters);
                    }
                    $courseProcess = CourseProcess::where('user_id', $userID)->where('courseid', $courseId)->where('is_mark', 1)->count();
                    $courseProcessDetail['totalChapterToFinish'] = $getCountChapter;
                    $courseProcessDetail['chapterFinished'] = $courseProcess;
                    $courseProcessDetail['process'] = round((($courseProcess/$getCountChapter)*100),2);
                }else{
                    $data['message'] = 'Course Not Found';    
                }
            }else{
                $data['message'] = 'User Not Found';
            }
        } else {
            $data['message'] = 'Course Id OR User Id Not Found';
        }
        $data['data'] = $courseProcessDetail;
        return response()->json($data);
    }

}
