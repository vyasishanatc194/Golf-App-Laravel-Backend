<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VlogCategory;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */

class VlogCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    public function getCategoryList(Request $request)
    {
        $categories = VlogCategory::all();
        return response()->json([
            'data' => $categories,
            'message' => 'vlog_caterory_success',
            'status' => 200,
        ]);

    }

}
