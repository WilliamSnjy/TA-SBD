<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    // public function show all values from a table
    public function index()
    {
        $datas = DB::select('select * from pelanggan WHERE isdeleted = 0');
        return view('v_pelanggan')->with('datas', $datas);
    }

    public function cari(Request $request)
    {
    $datas = DB::select('
        SELECT * FROM pelanggan WHERE isdeleted = 0 AND LOWER(nama_pelanggan) LIKE :cari',
        ['cari' => '%' . strtolower($request->cari) . '%']
    );
    return view('v_pelanggan')->with('datas', $datas);
    }

    public function create()
    {
        return view('v_addpelanggan');
    }
    // public function store the value to a table
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => '',
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required',
        ]);
        DB::insert(
            'INSERT INTO pelanggan(nama_pelanggan, alamat, nomor_telepon, email) VALUES ( :nama_pelanggan, :alamat, :nomor_telepon, :email)',
            [
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
            ]
        );
        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil disimpan');
    }
    // public function edit a row from a table
    public function edit($id)
    {
        $data = DB::table('pelanggan')->where('id_pelanggan', $id)->first();
        return view('v_editpelanggan')->with('pelanggan', $data);
    }

    // public function to update the table value
    public function update($id, Request $request)
    {
        $request->validate([
            'id_pelanggan' => '',
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required',
        ]);

        DB::update(
            'UPDATE pelanggan SET nama_pelanggan = :nama_pelanggan, alamat = :alamat, nomor_telepon = :nomor_telepon, email = :email WHERE id_pelanggan = :id',
            [
                'id' => $id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
            ]
        );

        return redirect()->route('pelanggan.index')->with('success', 'Data Barang berhasil diubah');
    }
    // public function to delete a row from a table
    public function delete($id)
    {
        DB::delete('UPDATE pelanggan SET isdeleted = 1 WHERE id_pelanggan = :id_pelanggan', ['id_pelanggan' => $id]);
        return redirect()->route('pelanggan.index')->with('pesan', 'Data Barang berhasil dihapus');
    }
    public function restore()
    {
        DB::update('UPDATE pelanggan SET isdeleted = 0 WHERE isdeleted = 1');
        return redirect()->route('pelanggan.index')->with('pesan', 'Data Barang berhasil dihapus');
    }
    public function deleted()
    {
        DB::delete('DELETE FROM pelanggan WHERE isdeleted = 1');
        return redirect()->route('pelanggan.index')->with('pesan', 'Data Barang berhasil dihapus');
    }
}
