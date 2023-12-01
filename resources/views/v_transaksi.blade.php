@extends('layout.v_template')
@section('title' , 'Transaksi')

@section('content')
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#deleted">Permanent Delete</button>
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#restore">Restore</button>
<a href="/transaksi/add" class="btn btn-primary btn-sm">Tambah Data</a> </br>
<form action="/transaksi/cari" method="get" class="sidebar-form">
        <div class= "input-group">
          <input type="text" name="cari" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" value="CARI" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>

@if (session('pesan'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i>Berhasil</h4>
    {{ session('pesan') }}
</div>
@endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama</th>
                <th>Banyak</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->id_transaksi }}</td>
                    <td>{{ $data->Nama }}</td>
                    <td>{{ $data->Banyak }}</td>
                    <td>{{ $data->Produk }}</td>
                    <td>{{ $data->harga }}</td>
                    <td>{{ $data->total }}</td>
                    <td>
                        <a href="/transaksi/edit/{{ $data->id_transaksi }}" class="btn btn-sm btn-warning">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $data->id_transaksi }}">
                                Delete
                            </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @foreach ($datas as $data)
    <div class="modal modal-danger fade" id="delete{{ $data->id_transaksi }}">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_transaksi }}</h4>
              </div>
              <form method="POST" action="{{ route('transaksi.delete', $data->id_transaksi) }}">
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
    <!-- Modal Restore -->
    <div class="modal modal-danger fade" id="restore">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Restore Deleted Data </h4>
                </div>
                <form method="POST" action="{{ route('transaksi.restore') }}">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin merestore data?</p>
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
    <!-- Modal Restore -->
    <div class="modal modal-danger fade" id="deleted">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Permanent Deleted Data </h4>
                </div>
                <form method="POST" action="{{ route('transaksi.deleted') }}">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin merestore data?</p>
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