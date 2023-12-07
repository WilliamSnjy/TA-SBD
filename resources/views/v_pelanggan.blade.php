@extends ('layout.v_template')
@section ('title', 'Data Pelanggan')

@section('content')
<a href="/pelanggan/add" class="btn btn-primary btn-sm">Tambah Data</a>
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#restore">Restore</button>
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleted">Permanent Delete</button>
</br>
    <form action="/pelanggan/cari" method="get" class="sidebar-form">
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
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->id_pelanggan }}</td>
                    <td>{{ $data->nama_pelanggan }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->nomor_telepon }}</td>
                    <td>{{ $data->email }}</td>
                    <td>
                        <a href="/pelanggan/edit/{{ $data->id_pelanggan }}" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $data->id_pelanggan }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($datas as $data)
    <div class="modal modal-danger fade" id="delete{{ $data->id_pelanggan }}">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $data->id_pelanggan }}</h4>
              </div>
              <form method="POST" action="{{ route('pelanggan.delete', $data->id_pelanggan) }}">
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
                <form method="POST" action="{{ route('pelanggan.restore') }}">
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
                <form method="POST" action="{{ route('pelanggan.deleted') }}">
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