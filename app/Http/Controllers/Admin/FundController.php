<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Fund;
use App\Exports\FundExport;
use Maatwebsite\Excel\Facades\Excel;


class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(auth()->user());
        return Inertia::render('Admin/Funds',[
            'funds'=>Fund::withCount('expends')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/FundCreate',[
            'categories'=>Category::all(),
            'fund'=>(Object)[
                'fund_category_id'=>1,
                'grants'=>[],
                'repayments'=>[]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data=$request->all();
        // $data['grants']=json_encode($request->grants);
        // $data['repayments']=json_encode($request->repayments);
        $fund=Fund::create($data);
        return redirect()->route('admin.fund.items.index',$fund->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        $categoryItemIds=$fund->items->keyBy('category_item_id')->pluck('category_item_id')->toArray();
        $fund->summary();
        return Inertia::render('Admin/FundSummary',[
            'categoryItems'=>CategoryItem::whereIn('id',$categoryItemIds)->with('accounts')->get(),
            'fund'=>$fund,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund)
    {
        return Inertia::render('Admin/FundCreate',[
            'categories'=>Category::all(),
            'fund'=>$fund
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fund $fund)
    {
        $fund->update($request->all());
        return redirect()->route('admin.fund.items.index',$fund->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggleClose(Fund $fund){
        $fund->is_closed=!$fund->is_closed;
        $fund->save();
       
    }


    public function export(Fund $fund){
        return Excel::download(new FundExport($fund), 'fund.xlsx');

    }
}
