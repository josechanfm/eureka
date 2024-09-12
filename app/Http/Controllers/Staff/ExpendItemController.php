<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Expend;
use App\Models\ExpendItem;

class ExpendItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Expend $expend)
    {
        $expend->items;
        $fund=$expend->fund;
        $fund->items;
        $availableAccounts=$fund->availableAccounts();
        return Inertia::render('Staff/ExpendItems',[
            'categoryItems'=>Category::find(1)->items,
            'fund'=>$fund,
            'expend'=>$expend,
            'availableAccounts'=>$availableAccounts
            //'items'=>$expend->items
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
    public function store(Expend $expend, Request $request)
    {

        $expendItem=ExpendItem::create([
            'expend_id'=>$expend->id,
            'fund_item_account_id'=>$request->accountId,
            'description'=>$request->description,
            'amount'=>$request->amount
        ]);
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
    public function update(Request $request, Expend $expend, ExpendItem $item)
    {
        // dd($expend, $item);
        $item->update($request->all());
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
