<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */

class StudyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {

        $roleCount = \App\Role::count();
        if ($roleCount != 0) {
            if ($roleCount != 0) {
                return view('home');
            }
        } else {
            return view('errors.error', [
                'title' => 'Migration not completed',
                'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
            ]);
        }

    }

    public function getCourseList(Request $request)
    {

        /**========================== Start Course Service ==============================**/

//    $results = DB::select( DB::raw("select courses.name as course_name, courses.id as course_id, unimodules.name as unimodule_name, unimodules.id as unimodule_id, chapters.name as chapter_name, chapters.id as chapter_id, skills.name as skill_name, skills.id as skill_id, videos.name as video_name, videos.id as video_id, videos.url from courses LEFT JOIN unimodules ON courses.id = unimodules.course_id LEFT JOIN chapters ON unimodules.id = chapters.module_id LEFT JOIN skills ON chapters.id = skills.chapter_id LEFT JOIN videos ON skills.id = videos.skill_id WHERE academy_id = 1 AND unimodules.name IS NOT NULL AND skills.name IS NOT NULL AND videos.name IS NOT NULL"));
        $courses = \App\Models\Ext\Course::all();
        return response()->json([
            'data' => $courses,
            'message' => 'course_success',
            'status' => 200,
        ]);

        /**========================== End Course Service ================================**/
    }

    public function courses(Request $request)
    {

        /**========================== Start Course Service ==============================**/

        $results = DB::select(DB::raw("select * from courses"));

        return response()->json([
            'data' => $results,
            'message' => 'course_success',
            'status' => 200,
        ]);

        /**========================== End Course Service ================================**/
    }

    public function unimodules(Request $request)
    {

        /**========================== Start UniModule Service ==============================**/
        $course_id = $request->get('course_id');

        $results = DB::select(DB::raw("select * from unimodules where course_id = " . $course_id));

        return response()->json([
            'data' => $results,
            'message' => 'unimodule_success',
            'status' => 200,
        ]);

        /**========================== End UniModule Service ================================**/
    }

    public function chapters(Request $request)
    {

        /**========================== Start Chapter Service ==============================**/
        $module_id = $request->get('unimodule_id');

        $results = DB::select(DB::raw("select * from chapters where module_id = " . $module_id));

        return response()->json([
            'data' => $results,
            'message' => 'chapter_success',
            'status' => 200,
        ]);

        /**========================== End Chapter Service ================================**/
    }

    public function vimeo_video(Request $request)
    {

        /**========================== Start Chapter Service ==============================**/
        $course_id = $request->get('course_id');
        $module_id = $request->get('unimodule_id');
        $chapter_id = $request->get('chapter_id');

        $results = DB::select(DB::raw("select html from vimeo_video where course_id = " . $course_id . " and module_id = " . $module_id . " and chapter_id = " . $chapter_id));

        return response()->json([
            'data' => $results,
            'message' => 'chapter_success',
            'status' => 200,
        ]);

        /**========================== End Chapter Service ================================**/
    }

    public function getCourseDetail(Request $request, $id,  $userID = null)
    {
        if($userID > 0){
            $course = \App\Models\Ext\Course::where('id', $id)
        //->select('id','name','description','modules')
        //->with(['modules', 'academy'])
                ->with([
                    'modules' => function ($query1) use ($userID) {
                        $query1->with(['chapters' => function ($query1) use ($userID) {
                            $query1->with(['video']);
                            $query1->with(['courseCheckCompleted'=> function($query) use ($userID) {
                                $query->where('user_id', $userID);
                            }]);
                        }]);
                    }
                ])
                ->get();
            
            if(count($course) > 0){
                $modules = $course[0]->modules;
                foreach($modules as $key => $module){
                    $chapters = $module->chapters;
                    foreach($chapters as $chapterKey => $chapter){
                        if($chapter->courseCheckCompleted == ''){
                            $course[0]->modules[$key]->chapters[$chapterKey]->is_mark = 0;  
                        }else{
                            $course[0]->modules[$key]->chapters[$chapterKey]->is_mark = $chapter->courseCheckCompleted->is_mark; 
                        }
                    }
                }
            }
        }else{
            $course = \App\Models\Ext\Course::where('id', $id)
        //->select('id','name','description','modules')
        //->with(['modules', 'academy'])
            ->with([
                'modules' => function ($query1) {
                    $query1->with(['chapters' => function ($query1) {
                        $query1->with(['video']);
                    }]);
                }])
            ->get();
        }
        
          //  $abc= (array)$course;

//          print_r($abc);  
        //exit;

        $json = response()->json([
            'data' => $course,
            'message' => 'course_success',
            'status' => 200,
        ]);


    return $json; 


        /**========================== End Course Service ================================**/

    }

    public function academyList()
    {
        $academy_data = Academy::all();

        $url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = $_SERVER;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $contents = curl_exec($ch);
        curl_close($ch);
        
        return response()->json([
            'data' => $academy_data,
            'message' => 'academy_record_fetch_success',
            'status' => 200,
        ]);

    }

}
