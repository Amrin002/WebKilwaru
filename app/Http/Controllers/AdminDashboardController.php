<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    public function index()

    {
        $titleHeader = "Dashboard Admin";
        return view('admin.index', compact('titleHeader'));
    }
}
