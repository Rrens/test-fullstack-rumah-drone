@extends('components.master')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Stock Out
                <small>Barang Keluar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Stock Out</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Stock Out</h3>
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
                                        <th>Info</th>
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
                                        <td>Win 95+</td>
                                        <td> 4</td>
                                        <td>X</td>
                                        <td>
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
                    <h4 class="modal-title">Add Supplier</h4>
                </div>
                <form action="http://localhost/awrmotor/supplier/process" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Date *</label>
                            <input type="date" name="date" value="2023-12-09" class="form-control" required="">
                        </div>
                        <div>
                            <label for="barcode">Barcode</label>
                        </div>
                        <div class="form-group input-group">
                            <input type="hidden" name="item_id" id="item_id">
                            <input type="text" name="barcode" id="barcode" class="form-control" required=""
                                autofocus="">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" data-toggle="modal"
                                    data-target="#modalItemAdd">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Item Name *</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" readonly="">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="unit_name">Item Unit</label>
                                    <input type="text" name="unit_name" id="unit_name" value="-"
                                        class="form-control" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <label for="stock">Initial Stock</label>
                                    <input type="text" name="stock" id="stock" value="-" class="form-control"
                                        readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Detail *</label>
                            <input type="text" name="detail" class="form-control" placeholder="Keluar/Hilang"
                                required="">
                        </div>
                        <div class="form-group">
                            <label>Qty *</label>
                            <input type="number" name="qty" class="form-control" required="">
                        </div>
                        <div class="modal-footer">
                            <div style="float: right;">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalItemAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Select Product Item</h4>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A001</td>
                                <td>Kampas Rem Honda</td>
                                <td>Unit</td>
                                <td class="text-right">Rp. 15.000</td>
                                <td class="text-right">110</td>
                                <td>
                                    <button class="btn btn-xs btn-info" id="select" data-id="10"
                                        data-barcode="A001" data-name="Kampas Rem Honda" data-unit="Unit"
                                        data-stock="110">
                                        <i class="fa fa-check"> Select</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>A002</td>
                                <td>Oli Motul</td>
                                <td>Unit</td>
                                <td class="text-right">Rp. 80.000</td>
                                <td class="text-right">222</td>
                                <td>
                                    <button class="btn btn-xs btn-info" id="select" data-id="11"
                                        data-barcode="A002" data-name="Oli Motul" data-unit="Unit" data-stock="222">
                                        <i class="fa fa-check"> Select</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>A003</td>
                                <td>Lampu Honda</td>
                                <td>Unit</td>
                                <td class="text-right">Rp. 30.000</td>
                                <td class="text-right">333</td>
                                <td>
                                    <button class="btn btn-xs btn-info" id="select" data-id="12"
                                        data-barcode="A003" data-name="Lampu Honda" data-unit="Unit" data-stock="333">
                                        <i class="fa fa-check"> Select</i>
                                    </button>
                                </td>
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
                    <h4 class="modal-title">Delte Supplier</h4>
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
                    var item_id = $(this).data('id');
                    var barcode = $(this).data('barcode');
                    var name = $(this).data('name');
                    var unit_name = $(this).data('unit');
                    var stock = $(this).data('stock');
                    $('#item_id').val(item_id);
                    $('#barcode').val(barcode);
                    $('#item_name').val(name);
                    $('#unit_name').val(unit_name);
                    $('#stock').val(stock);
                    $('#modalItemAdd').modal('hide');
                })
            })
        </script>
    @endpush
@endsection
