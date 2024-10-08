<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Budget;
use App\Models\Fund;
use App\Exports\BudgetExport;
use Maatwebsite\Excel\Facades\Excel;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Fund $fund)
    {
        return Inertia::render('Admin/Budgets',[
            'fund'=>$fund,
            'budgets'=>Budget::whereBelongsTo($fund)->get()
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
        $data['creator_id']=auth()->user()->id;
        Budget::create($data);
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
    public function edit(Fund $fund, Budget $budget)
    {
        //dd($fund, $budget);
        return Inertia::render('Admin/BudgetCreate',[
            'fund'=>$fund,
            'budget'=>$budget
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Fund $fund, Budget $budget, Request $request)
    {
        $data=$request->all();
        $data['updater_id']=auth()->user()->id;
        $budget->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund, Budget $budget)
    {
    }
    public function genReferenceCode($budget){
        $codePrefix=$budget->fund->category->initial;
        $codePrefix.=substr('0000'.$budget->fund->id,-4).'-';
        $codePrefix.=substr('0000'.$budget->id,-4);
        foreach($budget->items as $i=>$item){
            $item->reference_code=$codePrefix.'-'.substr('00'.($i+1),-2);
            $item->save();
        };
    }
    public function changeStatus(Budget $budget, Request $request){
        switch($request->status){
            case 'RETURN':
                $budget->status='S2';
                break;
            case 'REVIEW':
                $budget->status='S3';
                break;
            case 'ACCEPT':
                $budget->status='S4';
                break;
            case 'PROPOSE':
                if(!$budget->canSubmit()){
                    return redirect()->back()->withErrors(['message'=>'Account Code Not completed!']);
                    break;
                }
                $budget->status='S5';
                $this->genReferenceCode($budget);
                break;
            case 'REWORK':
                $budget->status='S4';
                break;
            case 'ARCHIVE':
                $budget->status='S6';
                break;
        }
        $budget->save();
        return redirect()->back();
    }

    public function export(Budget $budget){
        $fileName='Budget_'.($budget->proposal_number??'budget_items').'.xlsx';
        return Excel::download(new BudgetExport($budget), $fileName);
    }


}
