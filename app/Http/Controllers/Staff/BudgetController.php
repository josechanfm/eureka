<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Fund;


class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Fund $fund)
    {
        if($fund->is_submitted==false || $fund->is_closed || !$fund->isMember()){
            return redirect()->route('staff.funds.index');
        }
        return Inertia::render('Staff/Budgets',[
            'categories'=>Category::where('type',$fund->category)->get(),
            'fund'=>$fund,
            'budgets'=>Budget::whereBelongsTo($fund)->with('category')->with('items')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Fund $fund, Request $request)
    {
        $data=$request->all();
        $data['owner_id']=auth()->user()->id;
        $data['creator_id']=auth()->user()->id;
        $data['status']='S1';
        Budget::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund, Budget $budget)
    {
        //dd($fund, $budget);
        return Inertia::render('Staff/BudgetCreate',[
            'fund'=>$fund,
            'budget'=>$budget
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Fund $fund, Budget $budget, Request $request)
    {
        $data=$request->all();
        $data['updater_id']=auth()->user()->id;
        $budget->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund, Budget $budget)
    {
        $budget->delete();
        return redirect()->route('staff.fund.budgets.index',$fund->id);
    }
    
}
