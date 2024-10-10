<?php

namespace App\Http\Controllers\Staff;

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
        $fund->items;
        $categroy=$fund->category;
        //$categroy=Category::latestVersion('FDCT',$budget->year);
        //dd($categroy, $fund);
        if(empty($categroy)){
            return redirect()->route('dashboard');
        }
        
        //dd(Category::where('version',$budget->year)->first());
        $availableSplits=$fund->availableSplits();
        return Inertia::render('Staff/BudgetItems',[
            'categoryItems'=>$categroy->items,
            'fund'=>$fund,
            'budget'=>$budget,
            'availableSplits'=>$availableSplits
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
        //$toSubmit=$request->toSubmit;
        $items=$request->items;
        $budget->items()->whereNotIn('id',array_column($items,'id'))->delete();
        
        foreach($items as $i=>$item){
            unset($items[$i]['created_at']);
            unset($items[$i]['updated_at']);
            unset($items[$i]['split']);
            unset($items[$i]['reserved']);
            unset($items[$i]['expend_items']);
        }
        foreach($items as $item){
            if(isset($item['id'])){
                $item['creator_id']=auth()->user()->id;
                //dd($item,BudgetItem::where('id',$item['id'])->get());
                BudgetItem::where('id',$item['id'])->update($item);
            }else{
                $item['updater_id']=auth()->user()->id;
                BudgetItem::create($item);
            }
        }
        if($request->toSubmit){
            $budget->setSubmitted();
        }
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
    public function update(Request $request, Budget $budget, BudgetItem $item)
    {
        $data=$request->all();
        unset($data['split']);
        unset($data['reserved']);
        $item->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget, BudgetItem $item)
    {
        dd($item);
    }
}
