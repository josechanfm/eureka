<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CategoryItem;
use App\Models\CategoryItemAccount;

class CategoryItemAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryItem $item)
    {
        $item->accounts;
        $item->category;
        return Inertia::render('Admin/CategoryItemAccounts',[
            'item'=>$item
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
    public function store(CategoryItem $item, Request $request)
    {
        $item->accounts()->create($request->all());
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
    public function update(CategoryItem $item, CategoryItemAccount $account, Request $request)
    {
        $account->update($request->all());
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
