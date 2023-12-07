@extends('layout.v_template')
@section('title' , 'Tambah Transaksi')

@section('content')

<form action="/transaksi/insert" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="content">
        <div class="row">
            <div class="col-sm-6">

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
                    <label>Jumlah Produk</label>
                    <input name="jumlah_produk" class="form-control" value="{{ old('jumlah_produk') }}">
                    <div class="text-success">
                        @error('jumlah_produk')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                </br>
                <div class="form-group">
                    <button class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#checkout"> CheckOut
                    </button>
                </div>

            </div>
            <div class="col-sm-6">
                <table class="table">
                    <thead>
                        <th>Banyak</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <?php
                        $grandtotal=0;
                    ?>
                        @foreach($datas3 as $data)
                        <tr>
                            <td>{{ $data->Banyak }}</td>
                            <td>{{ $data->Produk }}</td>
                            <td>{{ $data->harga }}</td>
                            <td>{{ $data->total }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#cancel{{ $data->id_transaksi }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php
                                $grandtotal=$grandtotal+$data->total;
                            ?>
                        @endforeach
                        <tr>
                            <td colspan="3">Total Harga</td>
                            <td>{{ $grandtotal }}</td>
                            <td> <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#cancel">Cancel all</button> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</form>
@foreach ($datas3 as $data)
<div class="modal modal-danger fade" id="cancel{{ $data->id_transaksi }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_transaksi }}</h4>
            </div>
            <form method="POST" action="{{ route('transaksi.cancel', $data->id_transaksi) }}">
                @csrf
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-outline pull-right">Yes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endforeach
<div class="modal modal-primary fade" id="checkout">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Checkout Barang </h4>
            </div>
            <form method="POST" action="{{ route('transaksi.checkout') }}">
                @csrf
                <div class="modal-body">
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

                    <div class="form-group">
                        <label>Tanggal Transaksi</label>
                        <input name="tanggal_transaksi" type="date" class="form-control"
                            value="{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}">

                        <div class="text-danger">
                            @error('tanggal_transaksi')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>

                </div>
                </br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-outline pull-right">Yes</button>
        </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<div class="modal modal-danger fade" id="cancel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Cancel All Data </h4>
            </div>
            <form method="POST" action="{{ route('transaksi.canceled') }}">
                @csrf
                <div class="modal-body">
                    <p>Apakah anda yakin ingin membatalkan transaksi?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-outline pull-right">Yes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection