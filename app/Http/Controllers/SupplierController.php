<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];
        $activeMenu = 'supplier'; // Set menu yang sedang aktif

        $supplier = SupplierModel::all();

        return view('supplier.index', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $m_suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        // Filter data supplier berdasarkan supplier_id (jika diperlukan)
        if ($request->supplier_id) {
            $m_suppliers->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($m_suppliers)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                $btn = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];
        $supplier = SupplierModel::all(); // ambil data supplier (mungkin tidak diperlukan di form create)
        $activeMenu = 'supplier'; // set menu yang sedang aktif

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data supplier baru
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'supplier_kode' => 'required|string|max:10|unique:m_suppliers,supplier_kode', // Tambahkan unique rule
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255',
        ]);

        // Buat supplier baru menggunakan Eloquent Mass Assignment
        SupplierModel::create($request->all());

        // Redirect dengan pesan sukses
        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan.');
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|max:10|unique:m_suppliers,supplier_kode', // Tambahkan unique rule
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $supplierData = $request->all();

            SupplierModel::create($supplierData);

            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan'
            ]);
        }

        return redirect()->route('supplier.index'); // Redirect jika bukan AJAX request (gunakan route() dan beri nama rute)
    }


    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    //  Menyimpan perubahan data supplier ajax
    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|max:10|unique:m_suppliers,supplier_kode,' . $id . ',supplier_id',
                'supplier_nama' => 'required|max:100',
                'supplier_alamat' => 'required|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = SupplierModel::find($id);
            if ($check) {
                $data = $request->only(['supplier_kode', 'supplier_nama', 'supplier_alamat']);

                $check->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data supplier tidak ditemukan',
                ]);
            }
        } else {
            return redirect('/supplier')->with('error', 'Gagal mengupdate data supplier.');
        }
    }

    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    // hapus ajax
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);

            if ($supplier) {
                $supplier->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data supplier tidak ditemukan'
                ]);
            }
        }
        return redirect('/supplier')->with('error', 'Gagal menghapus data supplier.'); // Redirect ke halaman supplier jika bukan AJAX
    }
}