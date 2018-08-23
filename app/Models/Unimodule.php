<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniModule extends Model
{
    use SoftDeletes;
	
	protected $table = 'unimodules';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function chapters()
	{
		return $this->hasMany("\App\Models\Chapter",'module_id','id')->with('glosarry')->select('id','module_id','id as chapter_id','name as chapter_name');
	}
}
