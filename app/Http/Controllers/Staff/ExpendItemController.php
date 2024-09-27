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
        $categroy=Category::latestVersion('FDCT',$expend->year);
        if(empty($categroy)){
            return redirect()->route('dashboard');
        }
        
        //dd(Category::where('version',$expend->year)->first());
        $availableSplits=$fund->availableSplits();
        return Inertia::render('Staff/ExpendItems',[
            'categoryItems'=>$categroy->items,
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
        //$toSubmit=$request->toSubmit;
        $items=$request->items;
        foreach($items as $i=>$item){
            unset($items[$i]['created_at']);
            unset($items[$i]['updated_at']);
        }
        foreach($items as $item){
            if(isset($item['id'])){
                $item['creator_id']=auth()->user()->id;
                ExpendItem::where('id',$item['id'])->update($item);
            }else{
                $item['updater_id']=auth()->user()->id;
                ExpendItem::create($item);
            }
        }
        if($request->toSubmit){
            $expend->setSubmitted();
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
    public function destroy(Expend $expend, ExpendItem $item)
    {
        dd($item);
    }
}
