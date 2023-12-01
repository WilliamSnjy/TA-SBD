<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $datas = DB::select('
        SELECT transaksi.id_transaksi, pelanggan.nama_pelanggan as Nama, transaksi.jumlah_produk As Banyak, barang.nama_barang as Produk, barang.harga, transaksi.jumlah_produk*barang.harga as total
        FROM transaksi
        INNER JOIN barang ON barang.id_barang = transaksi.id_barang
        INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan
        WHERE transaksi.isdeleted = 0
        ');
        return view('v_transaksi')->with('datas', $datas);
    }
    public function create()
    {
        return view('v_addtransaksi');
    }
    // public function store the value to a table
    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi' => '',
            'nomor_transaksi' => 'required',
            'tanggal_transaksi' => 'required',
            'jumlah_produk' => 'required',
            'id_barang' => 'required',
            'id_pelanggan' => 'required',
        ]);
        DB::insert(
            'INSERT INTO transaksi(nomor_transaksi, tanggal_transaksi, jumlah_produk, id_barang, id_pelanggan) VALUES (:nomor_transaksi, :tanggal_transaksi, :jumlah_produk, :id_barang, :id_pelanggan)',
            [
                'nomor_transaksi' => $request->nomor_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'jumlah_produk' => $request->jumlah_produk,
                'id_barang' => $request->id_barang,
                'id_pelanggan' => $request->id_pelanggan,
            ]
        );
        return redirect()->route('transaksi.index')->with('success', 'Data Transaksi berhasil disimpan');
    }
    // public function edit a row from a table
    public function edit($id)
    {
        $data = DB::table('transaksi')->where('id_transaksi', $id)->first();
        return view('v_edittransaksi')->with('transaksi', $data);
    }

    // public function to update the table value
    public function update($id, Request $request)
    {
        $request->validate([
            'id_transaksi' => '',
            'nomor_transaksi' => 'required',
            'tanggal_transaksi' => 'required',
            'jumlah_produk' => 'required',
            'id_barang' => 'required',
            'id_pelanggan' => 'required',
        ]);

        DB::update(
            'UPDATE transaksi SET nomor_transaksi = :nomor_transaksi, tanggal_transaksi = :tanggal_transaksi, jumlah_produk = :jumlah_produk, id_barang = :id_barang, id_pelanggan = :id_pelanggan WHERE id_transaksi = :id',
            [
                'id' => $id,
                'nomor_transaksi' => $request->nomor_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'jumlah_produk' => $request->jumlah_produk,
                'id_barang' => $request->id_barang,
                'id_pelanggan' => $request->id_pelanggan,
            ]
        );

        return redirect()->route('transaksi.index')->with('success', 'Data Barang berhasil diubah');
    }
    // public function to delete a row from a table
    public function delete($id)
    {
        DB::delete('UPDATE transaksi SET isdeleted = 1 WHERE id_transaksi = :id_transaksi', ['id_transaksi' => $id]);
        return redirect()->route('transaksi.index')->with('pesan', 'Data Barang berhasil dihapus');
    }
    public function restore()
    {
        DB::update('UPDATE transaksi SET isdeleted = 0 WHERE isdeleted = 1');
        return redirect()->route('transaksi.index')->with('pesan', 'Data transaksi berhasil dihapus');
    }
    public function deleted()
    {
        DB::delete('DELETE FROM transaksi WHERE isdeleted = 1');
        return redirect()->route('transaksi.index')->with('pesan', 'Data transaksi berhasil dihapus');
    }
}
