<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Review extends Model
{
    protected $table = 'reviews';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'course_id', 'user_id', 'title', 'description', "publish_flag", "flag"
	];
	
	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	protected $hidden = [
    ];


    public function user()
	{
		return $this->belongsTo("\App\Models\User")->select('id',DB::raw('CONCAT( first_name," ",last_name)  AS user_name'));
	}
}
