<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function dashboard()
    {
    	$data['title']      = 'Dashboard';
        $data['breadcrumb'] = 'Dashboard';
        return view('backend.dashboard', $data);
    }
}
