<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;

class DashboardController extends Controller
{
    public function index(){
        dd(Config::item('fund_categories'));
        return Inertia::render('Admin/Dashboard',[

        ]) ;      
    }
}
