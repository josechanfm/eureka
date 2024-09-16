<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
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
        $fund->acccounts;
        return Inertia::render('Admin/ExpendItems',[
            'expend'=>$expend,
            'availableSplits'=>$fund->availableSplits()
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
        $data=$request->all();
        $expendItem=ExpendItem::create($data);
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
    public function update(Expend $expend, ExpendItem $item, Request $request )
    {
        //dd($expend, $item, $request->all());
        $item->account_code=$request->account_code;
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
