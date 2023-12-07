<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $datas = DB::select('
        SELECT transaksi.id_transaksi, transaksi.nomor_transaksi, pelanggan.nama_pelanggan as Nama, transaksi.jumlah_produk As Banyak, barang.nama_barang as Produk, barang.harga, transaksi.jumlah_produk*barang.harga as total
        FROM transaksi
        INNER JOIN barang ON barang.id_barang = transaksi.id_barang
        INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan
        WHERE transaksi.isdeleted = 0
        ORDER BY id_transaksi
        ');
        return view('v_transaksi')->with('datas', $datas);
    }

    public function cari(Request $request)
    {
        $datas = DB::select('
        SELECT transaksi.nomor_transaksi as id_transaksi, pelanggan.nama_pelanggan as Nama, transaksi.jumlah_produk As Banyak, barang.nama_barang as Produk, barang.harga, transaksi.jumlah_produk*barang.harga as total
        FROM transaksi
        INNER JOIN barang ON barang.id_barang = transaksi.id_barang
        INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan
        WHERE transaksi.isdeleted = 0 AND pelanggan.nama_pelanggan like :cari
        ORDER BY id_transaksi',
            ['cari' => '%' . strtolower($request->cari) . '%']
        );
        return view('v_transaksi')->with('datas', $datas);
    }

    public function create()
    {
        $datas1 = DB::select('select * from pelanggan WHERE isdeleted = 0');
        $datas2 = DB::select('select * from barang WHERE isdeleted = 0');
        $datas3 = DB::select(
            'SELECT transaksi.id_transaksi, transaksi.jumlah_produk As Banyak, barang.nama_barang as Produk, barang.harga, transaksi.jumlah_produk*barang.harga as total
            FROM transaksi
            INNER JOIN barang ON barang.id_barang = transaksi.id_barang
            INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan
            WHERE transaksi.isdeleted = 9'
        );
        return view('v_addtransaksi')->with(['datas1' => $datas1, 'datas2' => $datas2, 'datas3' => $datas3]);
    }
    // public function store the value to a table
    public function store(Request $request)
    {
        $stock = DB::select(
            'SELECT stok-(SELECT IFNULL(SUM(transaksi.jumlah_produk), 0) FROM transaksi WHERE barang.id_barang=transaksi.id_barang AND transaksi.isdeleted IN (0, 9)) as stok 
             FROM barang
             WHERE id_barang=:id_barang',
            ['id_barang' => $request->id_barang]
        );
        Validator::extend('under_stok', function ($attribute, $value, $parameters, $validator) use ($stock) {
            return $value <= ($stock[0]->stok);
        });

        $request->validate([
            'jumlah_produk' => 'required|numeric|under_stok',
            'id_barang' => 'required',
        ]);
        DB::insert(
            'INSERT INTO transaksi(nomor_transaksi, jumlah_produk, id_barang, id_pelanggan, isdeleted) 
            VALUES (0, :jumlah_produk, :id_barang, 0, 9)',
            [
                'jumlah_produk' => $request->jumlah_produk,
                'id_barang' => $request->id_barang,
            ]
        );
        return redirect()->route('transaksi.create');
        // return view('v_addtransaksi');
    }

    public function checkout(Request $request)
    {
        $cart = DB::select('SELECT COUNT(*) AS carts FROM transaksi WHERE isdeleted=9');
        if (($cart[0]->carts) > 0) {
            $request->validate([
                'tanggal_transaksi' => '',
                'id_pelanggan' => 'required',
            ]);
            DB::update(
                'UPDATE transaksi 
             SET nomor_transaksi = (SELECT MAX(nomor_transaksi) FROM transaksi) + 1,
                tanggal_transaksi = :tanggal_transaksi, 
                id_pelanggan = :id_pelanggan,
                isdeleted = 0 
             WHERE isdeleted = 9',
                [
                    'tanggal_transaksi' => $request->tanggal_transaksi,
                    'id_pelanggan' => $request->id_pelanggan,
                ]
            );

            return redirect()->route('transaksi.index')->with('pesan', 'Transaksi berhasil');
        } else {
            return redirect()->route('transaksi.create');
        }
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

        return redirect()->route('transaksi.index')->with('pesan', 'Data Transaksi berhasil diubah');
    }
    // public function to delete a row from a table
    public function delete($id)
    {
        DB::delete('UPDATE transaksi SET isdeleted = 1 WHERE id_transaksi = :id_transaksi', ['id_transaksi' => $id]);
        return redirect()->route('transaksi.index')->with('pesan', 'Data Transaksi berhasil dihapus');
    }
    public function restore()
    {
        DB::update('UPDATE transaksi SET isdeleted = 0 WHERE isdeleted = 1');
        return redirect()->route('transaksi.index')->with('pesan', 'Data transaksi berhasil direstore');
    }
    public function deleted()
    {
        DB::delete('DELETE FROM transaksi WHERE isdeleted = 1');
        return redirect()->route('transaksi.index')->with('pesan', 'Data transaksi berhasil dihapus');
    }
    public function cancel($id)
    {
        DB::delete('DELETE FROM transaksi WHERE id_transaksi = :id_transaksi', ['id_transaksi' => $id]);
        return redirect()->route('transaksi.create');
    }
    public function canceled()
    {
        DB::delete('DELETE FROM transaksi WHERE isdeleted = 9');
        return redirect()->route('transaksi.create');
    }

    public function trash(Request $request)
    {
        $datas2 = DB::select('select * from barang WHERE isdeleted = 1');
        $datas1 = DB::select('select * from pelanggan WHERE isdeleted = 1');
        return view('v_trashbin')->with(['datas1' => $datas1, 'datas2' => $datas2]);
    }

    public function restoreB($id)
    {
        DB::update('UPDATE barang SET isdeleted = 0 WHERE id_barang = :id_barang', ['id_barang' => $id]);
        return redirect()->route('transaksi.trash')->with('pesan', 'Data Barang berhasil direstore');;
    }
    public function restoreP($id)
    {
        DB::update('UPDATE pelanggan SET isdeleted = 0 WHERE id_pelanggan = :id_pelanggan', ['id_pelanggan' => $id]);
        return redirect()->route('transaksi.trash')->with('pesan', 'Data Pelanggan berhasil direstore');;
    }
    public function deleteP($id)
    {
        try {
            DB::delete('DELETE FROM pelanggan WHERE id_pelanggan = :id_pelanggan', ['id_pelanggan' => $id]);
            return redirect()->route('transaksi.trash')->with('pesan', 'Data Pelanggan berhasil dihapus');
        } 
        catch (\Exception $e){
            return redirect()->route('transaksi.trash')->with('error', 'Data Pelanggan tidak dapat dihapus');
        }
    }
    public function deleteB($id)
    {
        try{
            DB::delete('DELETE FROM barang WHERE id_barang = :id_barang', ['id_barang' => $id]);
            return redirect()->route('transaksi.trash')->with('pesan', 'Data Barang berhasil dihapus');
        }
        catch(\Exception $e){
            return redirect()->route('transaksi.trash')->with('error', 'Data Barang tidak dapat dihapus');
        }
    }
}
