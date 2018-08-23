<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;
	
	protected $table = 'chapters';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function glosarry()
	{
		return $this->hasMany("App\Glossary",'chapter_id','id')->select('id','chapter_id','id as glossary_id','title as glossary_title','description as glossary_description');
	}
}
