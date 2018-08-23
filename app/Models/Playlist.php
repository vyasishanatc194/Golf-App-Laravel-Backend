<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use App\Models\PlayItem;

class Playlist extends Model
{
    use SoftDeletes;
	
	protected $table = 'playlists';
	
	protected $hidden = [
        
	];
	
	protected $fields = ['id','name','user_id','deleted_at'];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function playItemDetail(){
		//return $this->belongsToMany('App\PlayItems','videos','video_uid','id');
		return $this->belongsToMany('App\Models\Video', 'playitems', 'video_uid', 'id')->select('videos.*',DB::raw('playitems.id as playitemsid,playitems.playlist_id as playlistId'));
	}

}
