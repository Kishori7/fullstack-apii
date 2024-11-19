<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id); // Mencari produk berdasarkan ID
        if ($product) {
            return response()->json([
                'message' => 'Data ditemukan',
                'data' => $product
            ]);
        } else {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($request->all());
            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data' => $product
            ]);
        } else {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function getCheapestProduct()
    {
        // Pastikan ada setidaknya satu produk di database
        if (Product::count() == 0) {
            return response()->json(['error' => 'Tidak ada produk yang tersedia.'], 404);
        }

        // Ambil produk dengan harga termurah
        $cheapestProduct = Product::orderBy('price', 'asc')->first();

        return response()->json($cheapestProduct, 200);
    }

    // Endpoint untuk mendapatkan produk termahal
    public function getMostExpensiveProduct()
    {
        $mostExpensiveProduct = Product::orderBy('price', 'desc')->first();
        // Pastikan ada setidaknya satu produk di database
        if (Product::count() == 0) {
            return response()->json(['error' => 'Tidak ada produk yang tersedia.'], 404);
        }

        // Ambil produk dengan harga termahal
        

        return response()->json($mostExpensiveProduct, 200);
    }

    public function bulkUpdatePrices(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        // Lakukan pembaruan harga
        foreach ($validatedData['products'] as $productData) {
            $product = Product::find($productData['id']);
            $product->price = $productData['price'];
            $product->save();
        }
        return response()->json(['message' => 'Harga produk berhasil diperbarui.'], 200);
}
public function deleteProduct($id) {
    // Validasi ID
    $product = Product::find($id);

    if ($product) {
        $product->delete();
        return response()->json(["message" => "Product deleted successfully."]);
    } else {
        return response()->json(["message" => "Product not found."], 404);
    }
}
public function restore($id)
    {
        \Log::info('Trying to restore product with ID: ' . $id);
        // Cari produk yang telah dihapus sementara
        $product = Product::onlyTrashed()->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found or not deleted.'
            ], 404);
        }

        // Pulihkan produk
        $product->restore();
        \Log::info('Product restored: ' . $product->id);
        return response()->json([
            'message' => 'Product restored successfully.',
            'product' => $product,
        ], 200);
    }

}

