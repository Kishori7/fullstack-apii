<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            ]);
            $product = Product::create($validated);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ], 201);
            $category = Category::create($validated);
            return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return $category ? response()->json($category) : response()->json(['message' => 'Category not
        found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if ($category) {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        ]);
        
        $category->update($validated);
        return response()->json($category);
        }
        return response()->json(['message' => 'Category not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
if ($category) {
$category->delete();
return response()->json(['message' => 'Category deleted successfully']);
}
return response()->json(['message' => 'Category not found'], 404);
}

public function getProductsByCategory($id)
{
    // Cek apakah kategori dengan ID yang diberikan ada di database
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['error' => 'Kategori tidak ditemukan.'], 404);
    }

    // Ambil semua produk yang terkait dengan kategori ini
    $products = $category->products; // Pastikan relasi sudah benar di model Category

    // Kembalikan hasil dalam bentuk array JSON
    return response()->json($products, 200);
}

    }

