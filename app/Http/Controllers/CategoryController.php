<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'image' => ['required', 'image', 'mimes:jpeg,png,webp,avif', 'max:4096'],
        ]);

        // Simpan gambar di storage/app/public/categories
        $validatedData['image'] = $request->file('image')->store('categories', 'public');

        Category::create($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name,'.$category->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,avif', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')->store('categories', 'public');

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $validatedData['image'] = $newImage;
        }

        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Kategori masih digunakan oleh produk dan belum dapat dihapus.');
        }

        // Hapus gambar dari storage
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
