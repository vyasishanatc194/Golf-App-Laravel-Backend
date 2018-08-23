<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Playlist;
use App\Playitems;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */

class PlayListController extends Controller
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
    

     /*-------------------------------Get Playlist -----------------------------------------*/

    public function getPlayListDetail(Request $request, $user_id){
        $playlist = array();
        $data = array(
            'data' => $playlist,
            'message' => 'playlist_detail_success',
            'status' => 200,
        );
        if($user_id){
            $user = User::find($user_id);
            if(!empty($user)){
                $playlist = Playlist::with('playItemDetail')->where('user_id',$user_id)->get();
                if(!empty($playlist)){
                    $data['data'] = $playlist;
                }else{
                    $data['message'] = 'PlayList Not Found';    
                }
             }else{
                $data['message'] = 'User Not Found';    
            }
        }else{
            $data['message'] = 'User Not Found';
        }
        return response()->json($data);
    }

    /*-------------------------------End Get Playlist-------------------------------------------*/

    /*------------------------------- Add Playlist Start-------------------------------------------*/

    public function addtoplaylist($userID,$playlistName,$videoId){
        $data = array(
            'data' => '',
            'message' => 'Playlist Added',
            'status' => 200,
        );
        if($userID != '' && $playlistName != ''&& $videoId != ''){
            $user = User::find($userID);
            if(!empty($user)){
                $playlist = Playlist::where('name',$playlistName)->where('user_id', $userID)->first();
                if(empty($playlist)){
                    $playlist = new Playlist();
                    $playlist->name = $playlistName;
                    $playlist->user_id = $userID;
                    if($playlist->save()){
                        $playlistItem = new Playitems();
                        $playlistItem->playlist_id = $playlist->id;
                        $playlistItem->video_uid = $videoId;
                        $playlistItem->save();
                    }else{
                        $data['message'] = 'Error while adding, Please try again';
                    }
                }else{
                    
                    $playlistItem = Playitems::where('playlist_id', $playlist->id)->where('video_uid',$videoId)->first();
                    
                    if(empty($playlistItem)){
                        $playlistItem = new Playitems();
                        $playlistItem->playlist_id = $playlist->id;
                        $playlistItem->video_uid = $videoId;
                        $playlistItem->save();
                    }else{
                        $data['message'] = 'PlayList already Added';
                    }
                }
            }else{
                $data['message'] = 'User Not Found'; 
            }
        }else{
            $data['message'] = 'Give Proper Data';
        }
        return response()->json($data);
    }
    

    /*------------------------------- Add Playlist End-------------------------------------------*/
}
