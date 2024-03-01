@extends('components.master')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Kategori
                <small>Kategori Barang</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Kategori</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Kategori</h3>
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary btn-flat" data-toggle="modal"
                                    data-target="#modalAdd">
                                    <i class="fa fa-plus"> Tambah</i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#modalEdit{{ $item->id }}">
                                                    <i class="fa fa-pencil"> Edit</i>
                                                </button>
                                                <button data-toggle="modal" data-target="#modalDelete{{ $item->id }}"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"> Hapus</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah User</h4>
                </div>
                <form action="{{ route('register.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama User *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Username *</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" value="{{ old('password') }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="float: right;">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($data as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit User {{ $item->name }}</h4>
                    </div>
                    <form action="{{ route('register.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama User *</label>
                                <input type="number" name="id" value="{{ $item->id }}" hidden>
                                <input type="text" name="name" value="{{ $item->name }}" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Username *</label>
                                <input type="text" name="username" value="{{ $item->username }}"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Email *</label>
                                <input type="email" name="email" value="{{ $item->email }}" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" value="{{ $item->address }}" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div style="float: right;">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modalDelete{{ $item->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hapus User {{ $item->name }}</h4>
                    </div>
                    <form action="{{ route('register.delete') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                        </div>
                        <div class="modal-footer">
                            <div style="float: right;">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('head')
        <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
        <script>
            $(function() {
                $('#example1').DataTable()
                $('#example2').DataTable({
                    'paging': true,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false
                })
            })
        </script>
    @endpush
@endsection
