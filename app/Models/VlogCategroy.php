<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VlogCategory extends Model
{
    use SoftDeletes;
	
	protected $table = 'vlog_categories';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];
}