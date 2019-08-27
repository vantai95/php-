<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App,Lang, Session;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [];

        return view('admin.index', compact('params'));
    }

    public function changeLocalization($language){
        App::setLocale($language);
        Session::put('locale', $language);
        return redirect()->back();
    }

}
