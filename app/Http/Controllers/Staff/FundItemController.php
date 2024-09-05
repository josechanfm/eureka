<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Fund;
use App\Models\Category;
use App\Models\CategoryItemAccount;
use App\Models\FundItem;
use App\Models\FundItemAccount;

class FundItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Fund $fund)
    {
        $fund->items;
        return Inertia::render('Staff/FundItemCreate',[
            'category'=>Category::with('items')->find(1),
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
        $items=$request->all();
        $fundItems=FundItem::whereNotIn('id',array_column($items,'id'))->delete();
        //dd($fundItems);

        //dd($items);
        foreach($items as $item){
            $accounts=$item['accounts'];
            unset($item['accounts']);
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
            

            foreach($accounts as $a){
                if(isset($a['id'])){
                    unset($a['created_at']);
                    unset($a['updated_at']);
                    FundItemAccount::where('id',$a['id'])->update($a);
                }else{
                    $cia=CategoryItemAccount::find($a['category_item_account_id']);
                    $a['account_code']=$cia->account_code;
                    //$a['fund_item_id']=$fundItem->id;
                    $fundItem->accounts()->create($a);
                }
            }
        }
        return redirect()->route('staff.funds.index');
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
