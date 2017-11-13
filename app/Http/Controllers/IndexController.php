<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\PageUtility;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function page(Request $request)
    {
        $keyword = $request->input('keyword');

        $startTime = microtime(true);
        $list = PageUtility::findUserViewedPage($keyword);
        $estimatedTime = microtime(true) - $startTime;
        $subList = array_slice($list, 0,10);

        $data =[
            'userPages' => $subList,
            'searchTime' => floor($estimatedTime * 1000),
            'result' => count($list),
        ];
        return view('page')->with($data);
    }
}