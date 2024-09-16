<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Fund;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Exports\FundExport;
use Maatwebsite\Excel\Facades\Excel;

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
        //dd(auth()->user());
        //$funds = Gate::allows('viewAny', Fund::class) ? Fund::all() : Fund::where('owner_id', auth()->id())->get();
        return Inertia::render('Staff/Funds',[
            'funds'=>Fund::whereBelongsTo(auth()->user(), 'ownedBy')->where('is_closed',false)->orderBy('created_at','DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fund=Fund::make(['category_id'=>1,'grants'=>[],'repayments'=>[]]);
        //dd('create fund',$fund);

        return Inertia::render('Staff/FundCreate',[
            'categories'=>Category::all(),
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
        //dd($request->all());
        $data=$request->all();
        // $data['grants']=json_encode($request->grants);
        // $data['repayments']=json_encode($request->repayments);
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
        if($fund->is_closed){
            return redirect()->route('staff.funds.index');
        }

        //$fund->items;
        foreach($fund->items as $item){
            $item->total=$item->accounts->sum('amount');
        }
        //dd('fund show',$fund);
        return Inertia::render('Staff/FundPdf',[
            'category'=>Category::with('items')->find(1),
            'fund'=>$fund,
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
            'categories'=>Category::all(),
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

    public function export(Fund $fund){
        return Excel::download(new FundExport($fund), 'fund.xlsx');

    }
}
