<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Fund;
use App\Models\Budget;
class DashboardController extends Controller
{
    public function index(){
        $stat['fundSubmitted']=Fund::where('is_submitted',true)->count();
        $stat['fundClosed']=Fund::where('is_closed',true)->count();
        $stat['budgetStatus']=Budget::select('status')->selectRaw('count(*) as count')->groupBy('status')->get()->pluck('total','status')->toArray();
        // $stat['budgetTotal']=Budget::whereNotIn('status',['S0,S1','S6'])->get()->map(function($budget){
        //     $budget->total_amount=$budget->items->sum('amount');
        //     return $budget;
        // });
        $budget=Budget::whereNotIn('status',['S0,S1','S6'])->get();
        $stat['budgetTotal']=$budget->sum('total');
        $stat['budgetCount']=$budget->count();
        return Inertia::render('Admin/Dashboard',[
            'stat'=>$stat
        ]);
    }
}
