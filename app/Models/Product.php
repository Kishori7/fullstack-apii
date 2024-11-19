<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;
        protected $table = 'products'; 
        protected $fillable = [
            'name',          // Tambahkan 'name' ke fillable
            'price',         // Tambahkan 'price' ke fillable
            'description',   // Tambahkan 'description' ke fillable
            'stock',
            'category_id'    // Kolom lain yang boleh diubah
        ];
        protected $dates = ['deleted_at'];
    public function category()
    {
    return $this->belongsTo(Category::class);
    }
    
    

    // Fungsi untuk menghapus produk berdasarkan ID
    public function deleteById($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Mengembalikan hasil eksekusi query (berhasil atau tidak)
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Jika terjadi kesalahan pada query
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
            return response()->json($data);
        }
    }
}
