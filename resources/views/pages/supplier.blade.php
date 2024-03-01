@extends('components.master')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            {{-- <h1>
                Suppliers Spare Part
                <small>Tambahan norek mungkin</small>
            </h1> --}}
            <br>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Supplier</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Supplier</h3>
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
                                        <th>Name Toko</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Nomor Rekening</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->norek }}</td>
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
                    <h4 class="modal-title">Tambah Toko</h4>
                </div>
                <form action="{{ route('supplier.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Toko *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor Telp *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat *</label>
                            <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="norek">Nomor Rekening</label>
                            <input type="text" type="number" name="norek" class="form-control" required>
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
                        <h4 class="modal-title">Edit Supplier</h4>
                    </div>
                    <form action="{{ route('supplier.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Toko *</label>
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <input type="text" name="name"
                                    value="{{ empty(old('name')) ? $item->name : old('name') }}" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>No Telp *</label>
                                <input type="text" name="phone"
                                    value="{{ empty(old('phone')) ? $item->phone : old('phone') }}" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Alamat *</label>
                                <textarea name="address" class="form-control" required>{{ empty(old('address')) ? $item->address : old('address') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="norek">Nomor Rekening</label>
                                <input type="text" type="number" name="norek" class="form-control"
                                    value="{{ empty(old('norek')) ? $item->norek : old('norek') }}" required>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hapus Toko {{ $item->name }}</h4>
                    </div>
                    <form action="{{ route('supplier.delete') }}" method="post">
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
