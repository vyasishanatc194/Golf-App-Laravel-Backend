<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Glossary;
use App\Models\Course;
use App\Models\Unimodule;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GlossaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /*-------------------------------Get Glosarry Listing-----------------------------------------*/

     public function getGlosarryListDetail(Request $request, $course_id){
        $glosarryList = array();
        $data = array(
            'data' => $glosarryList,
            'message' => 'glosarrylist_detail_success',
            'status' => 200,
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
        if($course_id > 0){
            $course = \App\Models\Ext\Course::find($course_id);
            if(!empty($course)){
                $glosarryList = Unimodule::with('chapters')->select('id','name as module_name')
                                ->where('course_id',$course_id)
                                ->get();
                                   
                if(count($glosarryList) > 0){
                    $data['data'] = $glosarryList;
                }else{
                    $data['message'] = 'Glosarry List Not Found';    
                }
             }else{
                $data['message'] = 'Course Not Found';    
            }
        }else{
            $data['message'] = 'Course Not Found';
        }
        return response()->json($data);
    }

    /*-------------------------------End Get Glosarry Listing-------------------------------------------*/

}
