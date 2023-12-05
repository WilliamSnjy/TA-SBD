@extends('layout.v_template')
@section('title' , 'Tambah Transaksi')

@section('content')

<form action="/transaksi/insert" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nomor Transaksi</label>
                    <input name="nomor_transaksi" class="form-control" value="{{ old('nomor_transaksi') }}">
                    <div class="text-danger">
                        @error('nomor_transaksi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <input name="tanggal_transaksi" type="date" class="form-control"
                        value="{{ old('tanggal_transaksi') }}">
                    <div class="text-danger">
                        @error('tanggal_transaksi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Jumlah Produk</label>
                    <input name="jumlah_produk" class="form-control" value="{{ old('jumlah_produk') }}">
                    <div class="text-danger">
                        @error('jumlah_produk')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>ID Barang</label>
                    <select name="id_barang" class="form-control">
                        @foreach($datas2 as $data)
                        <option value="{{ $data->id_barang }}">{{ $data->nama_barang }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('id_barang')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>ID Pelanggan</label>
                    <select name="id_pelanggan" class="form-control">
                        @foreach($datas1 as $data)
                        <option value="{{ $data->id_pelanggan }}">{{ $data->nama_pelanggan }}</option>
                        @endforeach
                    </select>

                    <div class="text-danger">
                        @error('id_pelanggan')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection