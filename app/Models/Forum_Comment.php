<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum_Comment extends Model
{
    use SoftDeletes;
	
	protected $table = 'forum_comments';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public static function checkComment($id){
		if($id){
			$getComment = \App\Models\Forum::CheckCommentsLike();
			return $getComment;
		}
		return true;
	}
}
