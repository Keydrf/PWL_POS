<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        return KategoriModel::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategoris,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);

        $kategori = KategoriModel::create($validated);
        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::findOrFail($id);

        $validated = $request->validate([
            'kategori_kode' => 'sometimes|string|max:10|unique:m_kategoris,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'sometimes|string|max:100',
        ]);

        $kategori->update($validated);
        return response()->json($kategori);
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }
}

