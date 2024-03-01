@extends('components.master')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Stock In
                <small>Barang Masuk</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Stock In</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Stock In</h3>
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
                                        <th>Barcode</th>
                                        <th>Product Item</th>
                                        <th>Qty</th>
                                        <th>Date</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Trident</td>
                                        <td>Internet
                                            Explorer 4.0
                                        </td>
                                        <td>Win 95+</td>
                                        <td> 4</td>
                                        <td>X</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modalDetail">
                                                <i class="fa fa-eye"> Detail</i>
                                            </button>
                                            <button data-toggle="modal" data-target="#modalDelete"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"> Hapus</i>
                                            </button>
                                        </td>
                                    </tr>
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
                    <h4 class="modal-title">Add Stock In</h4>
                </div>
                <form action="http://localhost/awrmotor/supplier/process" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Date *</label>
                            <input type="date" name="date" value="{{ $today }}" class="form-control"
                                required="">
                        </div>

                        <div>
                            <label for="barcode">Barcode</label>
                        </div>
                        <div class="form-group input-group">
                            <input type="hidden" name="item_id" id="item_id">
                            <input type="text" name="barcode" id="barcode" class="form-control" required=""
                                autofocus="" readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" data-toggle="modal"
                                    data-target="#modalItemAdd">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Name *</label>
                                    <input type="text" name="item_name" value="{{ old('item_name') }}" id="item_name"
                                        class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="stock">Stok</label>
                                    <input type="text" name="stock" id="stock" value="{{ old('stock') }}"
                                        class="form-control" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Supplier *</label>
                            <select name="supplier_id" class="form-control">
                                <option selected hidden>- Pilih -</option>
                                @foreach ($suppliers as $item)
                                    <option {{ old('supplier_id') == $item->id ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Qty *</label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control"
                                required="">
                        </div>
                        <div class="modal-footer">
                            <div style="float: right;">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalItemAdd" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Pilih Item Produk</h4>
                </div>
                <div class="modal-body table-responsive">
                    <div id="table1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->stock }}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-info" id="select"
                                                        data-id="{{ $item->id }}"
                                                        data-barcode="{{ $item->barcode }}"
                                                        data-name="{{ $item->name }}"
                                                        data-stock="{{ $item->stock }}">
                                                        <i class="fa fa-check"> Select</i>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetail">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Stock In Detail</h4>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered no-margin">
                        <tbody>
                            <tr>
                                <th>Barcode</th>
                                <td><span id="barcode"></span></td>
                            </tr>
                            <tr>
                                <th>Item Name</th>
                                <td><span id="item_name"></span></td>
                            </tr>
                            <tr>
                                <th>Detail</th>
                                <td><span id="detail"></span></td>
                            </tr>
                            <tr>
                                <th>Supplier Name</th>
                                <td><span id="supplier_name"></span></td>
                            </tr>
                            <tr>
                                <th>Qty</th>
                                <td><span id="qty"></span></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td><span id="date"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delte Sales In</h4>
                </div>
                <form action="http://localhost/awrmotor/supplier/process" method="post">
                    <div class="modal-body">
                        <input type="number" value="" name="id" hidden>
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
        <script>
            $(document).ready(function() {
                $(document).on('click', '#select', function() {
                    console.log($(this).data('barcode'))
                    var item_id = $(this).data('id');
                    var barcode = $(this).data('barcode');
                    var name = $(this).data('name');
                    var stock = $(this).data('stock');
                    $('#item_id').val(item_id);
                    $('#barcode').val(barcode);
                    $('#item_name').val(name);
                    $('#stock').val(stock);
                    $('#modalItemAdd').modal('hide');
                })
            })
        </script>
    @endpush
@endsection
