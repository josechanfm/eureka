<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Fund;
use App\Models\Category;
use App\Models\CategoryItemAccount;
use App\Models\FundItem;
use App\Models\FundItemSplit;

class FundItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Fund $fund)
    {
        $fund->items;
        //dd($fund->category_id);
        //dd(Category::with('items')->find($fund->category_id));
        return Inertia::render('Admin/FundItemForm',[
            //'category'=>Category::with('items')->find($fund->category_id),
            'category'=>Category::latestVersion($fund->category),
            'fund'=>$fund,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Fund $fund)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Fund $fund)
    {
        $this->authorize('view',$fund);
        $items=$request->items;
        //delete removed items
        $fund->items()->whereNotIn('id',array_column($items,'id'))->delete();

        foreach($items as $i=>$item){
            $item['sequence']=$i;
            $splits=$item['splits'];
            if(isset($item['id'])){
                $fundItem=FundItem::find($item['id']);
                $fundItem->splits()->whereNotIn('id',array_column($splits,'id'))->delete();
            }

            unset($item['splits']);
            if(isset($item['id'])){
                unset($item['created_at']);
                unset($item['updated_at']);
                //FundItem::where('id',$item['id'])->update($item);
                $fundItem=FundItem::find($item['id']);
                $fundItem->update($item);
                $fundItem->save();
            }else{
                $fundItem=$fund->items()->create($item);
                //$fundItem=FundItem::find($item['id']);
            }
            

            foreach($splits as $j=>$a){
                $a['sequence']=$j;
                if(isset($a['id'])){
                    unset($a['created_at']);
                    unset($a['updated_at']);
                    unset($a['reserved']);
                    FundItemSplit::where('id',$a['id'])->update($a);
                }else{
                    $fundItem->splits()->create($a);
                }
            }
            if($request->toSubmit){
                $fund->is_submitted=$request->toSubmit;
                $fund->save();
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {

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
    public function update(Request $request, Fund $fund, FundItem $fundItem)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
