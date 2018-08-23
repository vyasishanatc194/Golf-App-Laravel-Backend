<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vlog;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */

class VlogController extends Controller
{

    public function __construct()
    {

    }

    public function getVlogList(Request $request)
    {
        $vlogs = Vlog::all();

        return response()->json([
            'data' => $vlogs,
            'message' => 'vlog_success',
            'status' => 200,
        ]);
    }

    public function getVlogListByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = $_SERVER;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $contents = curl_exec($ch);
        curl_close($ch);
        $vlogs = Vlog::Where('category_id', $category_id)->get();
        return response()->json([
            'data' => $vlogs,
            'message' => 'vlog_success',
            'status' => 200,
        ]);

    }
}
