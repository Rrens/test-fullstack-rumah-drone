@extends('components.master')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            {{-- <h1>
                Items
                <small>Data Barang</small>
            </h1> --}}
            <br>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"> Sparepart</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Sparepart</h3>
                            @if (auth()->user()->level == 1)
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary btn-flat" data-toggle="modal"
                                        data-target="#modalAdd">
                                        <i class="fa fa-plus"> Tambah</i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barcode</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        @if (auth()->user()->level == 1)
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->barcode }} </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->category[0]->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->stock }}</td>
                                            @if (auth()->user()->level == 1)
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#modalEdit{{ $item->id }}">
                                                        <i class="fa fa-pencil"> Edit</i>
                                                    </button>
                                                    <button data-toggle="modal"
                                                        data-target="#modalDelete{{ $item->id }}"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"> Hapus</i>
                                                    </button>
                                                </td>
                                            @endif
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

    @if (auth()->user()->level == 1)

        <div class="modal fade" id="modalAdd">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tambah </h4>
                    </div>
                    <form action="{{ route('product.items.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Barcode *</label>
                                <input type="hidden" name="id" value="">
                                <input type="text" name="barcode" value="{{ $barcode }}" class="form-control"
                                    readonly required>
                            </div>

                            <div class="form-group">
                                <label for="name">Nama Produk *</label>
                                <input type="text" name="name" value="" class="form-control" required="">
                            </div>

                            <div class="form-group">
                                <label>Kategori *</label>
                                <select name="category_id" class="form-control" required="">
                                    @if (!empty($item))
                                        @foreach ($category as $row)
                                            <option
                                                {{ (!empty(old('category')) ? 'selected' : $item->category_id == $row->id) ? 'selected' : '' }}
                                                value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Harga *</label>
                                <input type="number" name="price" value="{{ old('price') }}" class="form-control"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>Stok *</label>
                                <input type="number" name="stock" value="{{ old('stock') }}" class="form-control"
                                    required="">
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
                            <h4 class="modal-title">Edit {{ $item->name }}</h4>
                        </div>
                        <form action="{{ route('product.items.update') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Barcode *</label>
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="text" name="barcode" value="{{ $item->barcode }}"
                                        class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Nama Produk *</label>
                                    <input type="text" name="name" id="name" value="{{ $item->name }}"
                                        class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>Kategori *</label>
                                    <select name="category_id" class="form-control" required="">
                                        @foreach ($category as $row)
                                            <option
                                                {{ (!empty(old('category')) ? 'selected' : $item->category_id == $row->id) ? 'selected' : '' }}
                                                value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga *</label>
                                    <input type="number" name="price" value="{{ $item->price }}"
                                        class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Stok *</label>
                                    <input type="number" name="stock" value="{{ $item->stock }}"
                                        class="form-control" required="">
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
                            <h4 class="modal-title">Hapus Item {{ $item->name }}</h4>
                        </div>
                        <form action="{{ route('product.items.delete') }}" method="post">
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

    @endif


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
