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
        //dd($fund->items);
        //dd(Category::where('version',$expend->year)->first());
        $availableSplits=$fund->availableSplits();
        return Inertia::render('Staff/ExpendItems',[
            'categoryItems'=>Category::find($fund->category_id)->items,
            'fund'=>$fund,
            'expend'=>$expend,
            'availableSplits'=>$availableSplits
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
        foreach($data as $i=>$d){
            unset($data[$i]['created_at']);
            unset($data[$i]['updated_at']);
        }
        foreach($data as $d)        {
            if(isset($d['id'])){
                $d['creater_id']=auth()->user()->id;
                ExpendItem::where('id',$d['id'])->update($d);
            }else{
                $d['updater_id']=auth()->user()->id;
                ExpendItem::create($d);
            }
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
