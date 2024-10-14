<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\Config;
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
        return Inertia::render('Admin/Funds',[
            //'categories'=>Category::where('active',true)->get(),
            'categories'=>Config::item('fund_categories'),
            'funds'=>Fund::withCount('budgets')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //dd($request->all());
        $result=$request->validate([
            'category' => [
                'required',
                'string',
            ]
        ]);
        $category=Category::latestVersion($result['category']);
        if(empty($category)){
            return redirect()->route('admin.funds.index');
        };
        $fund=Fund::make(['category'=>$result['category'],'grants'=>[],'repayments'=>[]]);
        //dd(Category::latestVersion($result['category']),$fund);
        return Inertia::render('Admin/FundForm',[
            'category'=>$category,
            'fund'=>$fund
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
        //$fund->summary();
        $fund->items();
        //dd($fund->items[0]->splits[0]->reserved);
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
        return Inertia::render('Admin/FundForm',[
            'category'=>$fund->category,    
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

    public function toggleSubmit(Fund $fund){
        $fund->is_submitted=!$fund->is_submitted;
        $fund->save();
    }

    public function toggleClose(Fund $fund){
        $fund->is_closed=!$fund->is_closed;
        $fund->save();
    }


    public function export(Fund $fund){
        return Excel::download(new FundExport($fund), 'fund.xlsx');

    }
}
