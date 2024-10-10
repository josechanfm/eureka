<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Budget;
use App\Models\BudgetItem;

class BudgetItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Budget $budget)
    {
        $budget->items;
        $fund=$budget->fund;
        $fund->acccounts;
        return Inertia::render('Admin/BudgetItems',[
            'categoryItems'=>Category::find($fund->category_id)->items,
            'budget'=>$budget,
            'availableSplits'=>$fund->availableSplits()
            //'items'=>$budget->items
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
    public function store(Budget $budget, Request $request)
    {
        $data=$request->all();
        $budgetItem=BudgetItem::create($data);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Budget $budget, BudgetItem $item, Request $request )
    {
        //dd($budget, $item, $request->all());
        $item->account_code=$request->account_code;
        $item->actual=$request->actual;
        $item->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
