<?php

namespace App\Http\Controllers\Staff;

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
        //dd($fund);
        return Inertia::render('Staff/Expends',[
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
        return Inertia::render('Staff/ExpendCreate',[
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
}
