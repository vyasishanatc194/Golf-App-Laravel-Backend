<?php

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

use App\Review;

class ReviewsController extends Controller
{
    public $show_action = true;
    public $view_col = 'title';
    public $listing_cols = ['id', 'title'];

    public function __construct()
    {
		// Field Access of Listing Columns
        if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
            $this->middleware(function ($request, $next) {
                $this->listing_cols = ModuleFields::listingColumnAccessScan('Reviews', $this->listing_cols);
                return $next($request);
            });
        } else {
            $this->listing_cols = ModuleFields::listingColumnAccessScan('Reviews', $this->listing_cols);
        }
    }

    public function index()
    {
        $module = Module::get('Reviews');

        if (Module::hasAccess($module->id)) {
            return View('la.reviews.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => $this->listing_cols,
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    public function store(Request $request)
    {
        if (Module::hasAccess("Reviews", "create")) {

            $rules = Module::validateRules("Reviews", $request);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Reviews", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.reviews.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    public function show($id)
    {
        if (Module::hasAccess("Reviews", "view")) {

            $reviews = Review::find($id);
            if (isset($reviews->id)) {
                $module = Module::get('Reviews');
                $module->row = $reviews;

                return view('la.reviews.show', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('category', $category);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reviews"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    public function edit($id)
    {
        if (Module::hasAccess("Reviews", "edit")) {
            $reviews = Review::find($id);
            if (isset($reviews->id)) {
                $module = Module::get('Reviews');

                $module->row = $reviews;

                return view('la.reviews.edit', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                ])->with('reviews', $reviews);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("reviews"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    public function update(Request $request, $id)
    {
        if (Module::hasAccess("Reviews", "edit")) {

            $rules = Module::validateRules("Reviews", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Reviews", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.reviews.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    public function destroy($id)
    {
        if (Module::hasAccess("Reviews", "delete")) {
            Review::find($id)->delete();
			
			// Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.reviews.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    public function dtajax()
    {
        $values = DB::table('reviews')->select($this->listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Reviews');

        for ($i = 0; $i < count($data->data); $i++) {
            for ($j = 0; $j < count($this->listing_cols); $j++) {
                $col = $this->listing_cols[$j];
                if ($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if ($col == $this->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/reviews/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
            }

            if ($this->show_action) {
                $output = '';
                if (Module::hasAccess("Reviews", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/reviews/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-sm" style="display:inline;"><i class="fa fa-edit"></i></a>';
                }

                if (Module::hasAccess("Reviews", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.reviews.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
