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
    public function index()
    {
        return Inertia::render('Admin/Expends',[
            'budgets'=>Budget::all(),
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
     * Store a newly created resource in storage.
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
    public function edit(Expend $expend)
    {
        $expend->items;
        //dd($expend);
        return Inertia::render('Admin/ExpendForm',[
            'budgets'=>Budget::where('status','S5')->get(),
            'expend'=>$expend
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expend $expend)
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
        return redirect()->back();
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
