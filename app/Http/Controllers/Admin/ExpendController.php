<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Budget;
use App\Models\Expend;
use App\Models\ExpendItem;
use App\Models\Fund;

class ExpendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Budget $budget)
    {
        //dd($budget);
        $budget->fund;
        $budget->category;
        return Inertia::render('Admin/Expends',[
            'budget'=>$budget,//Budget::with('items')->get(),
            'expends'=>Expend::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ExpendFrom',[
            
        ]);
    }

    /**
     * Store a newly created resource in storage.fund
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Budget $budget, Expend $expend)
    {
        $expend->items;
        $budget->items;
        //dd($budget, $expend);
        //$budgets=Budget::where('status','S5')->with('items')->get();
        // if($budgets->count()==0){
        //     return Inertia::render('Error',[
        //         'message'=>"You don't have any budget could use!"
        //     ]);
        // }
        return Inertia::render('Admin/ExpendForm',[
            'budget'=>$budget,
            'expend'=>$expend
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Budget $budget, Expend $expend, Request $request)
    {
        $expend->update($request->all());
        $itemIds=array_column($request->items,'id');
        $expend->items()->whereNotIn('id', $itemIds)->delete();
       
        foreach($request->items as $item){
            if(isset($item['id'])){
                ExpendItem::find($item['id'])->update($item);
            }else{
                $expend->items()->create($item);
            }
        }
        return to_route('admin.budget.expends.index',$expend->budget_id);
        // dd($expend, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
