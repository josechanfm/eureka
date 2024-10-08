<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\CategoryItem;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Categories',[
            'categories'=>Category::with('items')->get()
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
    public function store(Request $request)
    {
        Category::create($request->all());
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
    public function update(Request $request, Category $category)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'children' => 'array', // Expecting an array of child data
        //     'children.*.id' => 'sometimes|exists:children,id', // For existing children
        //     'children.*.name' => 'required|string', // Example field for child
        // ]);
        $category->update($request->all());
        
            // Handle child models
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (isset($item['id'])) {
                    // Update existing child
                    $child = CategoryItem::findOrFail($item['id']);
                    $child->update($item);
                } else {
                    // Create new child
                    $category->items()->create($item);
                }
            }
        }
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
