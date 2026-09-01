<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['required', 'image', 'mimes:jpeg,png,webp,avif', 'max:4096'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        // Simpan gambar di storage/app/public/products
        if ($request->hasFile('image')) {
            $validatedData['image'] = Storage::disk('public')->putFile('products', $request->file('image'));
        }

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,avif', 'max:4096'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        if ($request->hasFile('image')) {
            $newImage = Storage::disk('public')->putFile('products', $request->file('image'));

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $validatedData['image'] = $newImage;
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Hapus gambar dari storage/app/public
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
