<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::with('kategori')->get(); // Include kategori data
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:m_kategoris,kategori_id',
            'barang_kode' => 'required|string|max:10|unique:m_barangs,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
        ]);

        $barang = BarangModel::create($validated);
        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = BarangModel::with('kategori')->findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'sometimes|exists:m_kategoris,kategori_id',
            'barang_kode' => 'sometimes|string|max:10|unique:m_barangs,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'sometimes|string|max:100',
            'harga_beli' => 'sometimes|integer',
            'harga_jual' => 'sometimes|integer',
        ]);

        $barang->update($validated);
        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = BarangModel::findOrFail($id);
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus.',
        ]);
    }
}

