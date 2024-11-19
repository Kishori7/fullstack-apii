<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function getResource()
    {
        // Data yang akan dikirim sebagai respons
        $response = [
            'message' => 'Data ditemukan',
            'data' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2']
            ]
        ];

        // Kirimkan respons JSON
        return response()->json($response);
    }
    public function index()
{
    $items = [
        ['id' => 1, 'name' => 'Item 1'],
        ['id' => 2, 'name' => 'Item 2']
    ];

    return response()->json([
        'message' => 'Data ditemukan',
        'data' => $items
    ]);
}
}
