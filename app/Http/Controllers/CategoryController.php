<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::all(); // Silakan sesuaikan query-nya nanti
        return view('pages.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'icon' => 'nullable|string|max:255',
        ]);
        
        $validated['warung_id'] = 1; // Hardcode untuk saat ini sesuai plan
        $validated['order'] = $validated['order'] ?? 0;

        \App\Models\Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
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

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'icon' => 'nullable|string|max:255',
        ]);

        $category = \App\Models\Category::findOrFail($id);
        $validated['order'] = $validated['order'] ?? 0;
        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
