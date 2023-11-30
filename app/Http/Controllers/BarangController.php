<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // public function show all values from a table
    public function index()
    {
        $datas = DB::select('select * from barang');
        return view('v_barang')->with('datas', $datas);
    }

    public function create()
    {
        return view('v_addbarang');
    }
    // public function store the value to a table
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
        ]);
        DB::insert(
            'INSERT INTO barang(id_barang,nama_barang, harga, deskripsi, stok) VALUES (:id_barang, :nama_barang, :harga, :deskripsi, :stok)',
            [
                'id_barang' => $request->id_barang,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
            ]
        );
        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil disimpan');
    }
    // public function edit a row from a table
    public function edit($id)
    {
        $data = DB::table('barang')->where('id_barang', $id)->first();
        return view('v_editbarang')->with('barang', $data);
    }

    // public function to update the table value
    public function update($id, Request $request)
    {
        $request->validate([
            'id_barang' => '',
            'nama_barang' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
        ]);

        DB::update(
            'UPDATE barang SET nama_barang = :nama_barang, harga = :harga, deskripsi = :deskripsi, stok = :stok WHERE id_barang = :id',
            [
                'id' => $id,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
            ]
        );

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil diubah');
    }
    // public function to delete a row from a table
    public function delete($id)
    {
        DB::delete('DELETE FROM barang WHERE id_barang = :id_barang', ['id_barang' => $id]);
        return redirect()->route('barang.index')->with('pesan', 'Data Barang berhasil dihapus');
    }

}
