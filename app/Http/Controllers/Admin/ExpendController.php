<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Expend;
use App\Models\Fund;
use App\Exports\ExpendExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Fund $fund)
    {
        return Inertia::render('Admin/Expends',[
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
        $data['creator_id']=auth()->user()->id;
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
        return Inertia::render('Admin/ExpendCreate',[
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
    public function destroy(Fund $fund, Expend $expend)
    {
    }
    public function genReferenceCode($expend){
        $codePrefix=substr('0000'.$expend->id,-4);
        foreach($expend->items as $i=>$item){
            $item->reference_code=$codePrefix.'-'.substr('00'.($i+1),-2);
            $item->save();
        };
    }
    public function changeStatus(Expend $expend, Request $request){
        switch($request->status){
            case 'RETURN':
                $expend->status='S2';
                break;
            case 'REVIEW':
                $expend->status='S3';
                break;
            case 'ACCEPT':
                $expend->status='S4';
                break;
            case 'PROPOSE':
                if(!$expend->canSubmit()){
                    return redirect()->back()->withErrors(['message'=>'Account Code Not completed!']);
                    break;
                }
                $expend->status='S5';
                $this->genReferenceCode($expend);
                break;
            case 'REWORK':
                $expend->status='S4';
                break;
            case 'ARCHIVE':
                $expend->status='S6';
                break;
        }
        $expend->save();
        return redirect()->back();
    }

    public function export(Expend $expend){
        $fileName='Expend_'.($expend->proposal_number??'expend_items').'.xlsx';
        return Excel::download(new ExpendExport($expend), $fileName);
    }


}
