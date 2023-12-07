@extends('layout.v_template')
@section('title' , 'Trash Bin')

@section('content')

@if (session('pesan'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i>Berhasil</h4>
    {{ session('pesan') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-times"></i>Gagal</h4>
    {{ session('error') }}
</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Tipe</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas1 as $data)
        <tr>
            <td>{{ $data->id_pelanggan }}</td>
            <td>{{ $data->nama_pelanggan }}</td>
            <td>Pelanggan</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                    data-target="#restoreP{{ $data->id_pelanggan }}">
                    Restore
                </button>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                    data-target="#deleteP{{ $data->id_pelanggan }}">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
        @foreach ($datas2 as $data)
        <tr>
            <td>{{ $data->id_barang }}</td>
            <td>{{ $data->nama_barang }}</td>
            <td>Pelanggan</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                    data-target="#restoreB{{ $data->id_barang }}">
                    Restore
                </button>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                    data-target="#deleteB{{ $data->id_barang }}">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@foreach ($datas1 as $data)
<div class="modal modal-danger fade" id="deleteP{{ $data->id_pelanggan }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_pelanggan }}</h4>
            </div>
            <form method="POST" action="{{ route('transaksi.deleteP', $data->id_pelanggan) }}">
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

@foreach ($datas1 as $data)
<div class="modal modal-danger fade" id="restoreP{{ $data->id_pelanggan }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_pelanggan }}</h4>
            </div>
            <form method="POST" action="{{ route('transaksi.restoreP', $data->id_pelanggan) }}">
                @csrf
                <div class="modal-body">
                    <p>Apakah anda yakin ingin merestore?</p>
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

@foreach ($datas2 as $data)
<div class="modal modal-danger fade" id="deleteB{{ $data->id_barang }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_barang }}</h4>
            </div>
            <form method="POST" action="{{ route('transaksi.deleteB', $data->id_barang) }}">
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

@foreach ($datas2 as $data)
<div class="modal modal-danger fade" id="restoreB{{ $data->id_barang }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_barang }}</h4>
            </div>
            <form method="POST" action="{{ route('transaksi.restoreB', $data->id_barang) }}">
                @csrf
                <div class="modal-body">
                    <p>Apakah anda yakin ingin merestore?</p>
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

@endsection