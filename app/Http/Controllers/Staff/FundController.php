<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Fund;
use App\Models\User;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // Apply the policy for all resource actions
        $this->authorizeResource(Fund::class, 'fund');
    }
    public function index()
    {
        //$funds = Gate::allows('viewAny', Fund::class) ? Fund::all() : Fund::where('owner_id', auth()->id())->get();
        return Inertia::render('Staff/Funds',[
            'categories'=>Category::where('active',true)->get(),
            'funds'=>auth()->user()->funds->where('is_closed',false)->where('is_submitted',true)
            //'funds'=>Fund::whereBelongsTo(auth()->user(), 'ownedBy')->where('is_closed',false)->orderBy('created_at','DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //dd($request->all());
        $result=$request->validate([
            'id' => [
                'required',
                'integer',
                Rule::exists('categories')->where(function($query){
                    return $query->where('active',true);
                })
            ]
        ]);
        $fund=Fund::make(['category_id'=>1,'grants'=>[],'repayments'=>[]]);
        //dd('create fund',$fund);

        return Inertia::render('Staff/FundCreate',[
            'category'=>Category::find($request->id),
            'fund'=>$fund
            // 'fund'=>(Object)[
            //     'category_id'=>1,
            //     'grants'=>[],
            //     'repayments'=>[]
            // ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $fund=Fund::create($data);
        $categoryItems=Category::find($request->category_id)->items;
        foreach($categoryItems as $item){
            $fundItem=$fund->items()->create([
                'category_item_id'=>$item->id,
            ]);
            $fundItem->accounts()->create([
                'category_item_account_id'=>$item->accounts[0]->id,
                'user_define'=>$item->accounts[0]->user_define,
                'account_code'=>$item->accounts[0]->account_code
            ]);
        }
        return redirect()->route('staff.fund.items.index',$fund->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        return Inertia::render('Staff/FundShow',[
            'category'=>$fund->category,
            'fund'=>$fund
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund)
    {
        if($fund->is_closed){
            return redirect()->route('staff.funds.index');
        }
        return Inertia::render('Staff/FundCreate',[
            'category'=>$fund->category,
            'fund'=>$fund
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fund $fund)
    {
        if($fund->is_closed){
            return redirect()->route('staff.funds.index');
        }
        $fund->update($request->all());
        return redirect()->route('staff.fund.items.index',$fund->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
