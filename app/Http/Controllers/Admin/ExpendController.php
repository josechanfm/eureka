<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Expend;
use App\Models\Fund;

class ExpendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Fund $fund)
    {
        return Inertia::render('Admin/Expends',[
            'fund'=>$fund,
            'expends'=>Expend::whereBelongsTo($fund)->get()
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
        $data['creater_id']=auth()->user()->id;
        Expend::create($data);
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
    public function edit(Fund $fund, Expend $expend)
    {
        //dd($fund, $expend);
        return Inertia::render('Admin/ExpendCreate',[
            'fund'=>$fund,
            'expend'=>$expend
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Fund $fund, Expend $expend, Request $request)
    {
        $data=$request->all();
        $data['updater_id']=auth()->user()->id;
        $expend->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggleLock(Expend $expend){
        $expend->is_locked=!$expend->is_locked;
        $expend->save();
    }
    public function toggleClose(Expend $expend){
        $expend->is_closed=!$expend->is_closed;
        $expend->save();
       
    }

}
