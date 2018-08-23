<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dwij\Laraadmin\Models\Module;
class Forum extends Model
{
    use SoftDeletes;
	
	protected $table = 'forums';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public static function CheckCommentsLike(){
		return Module::all();
	}
}
