@extends('components.master')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                DAFTAR STOCK SPARE PART MIN MAX REALTIME
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Pembelian</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Real Time</h3>
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Spare Part</th>
                                        <th>Stok</th>
                                        <th>Stok Min</th>
                                        <th>Stok Max</th>
                                        <th>Safety Stok</th>
                                        <th>Lead Time</th>
                                        <th>Max Per</th>
                                        <th>Rata-rata Per</th>
                                        <th>Restok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($data_part as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nm_motor }}</td>
                                            <td>{{ $data->stok }}</td>
                                            {{-- KENE --}}
                                            <td>{{ ceil($hitung[$i]->rata / $jum_hari) * $data->time + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time }}
                                                Item</td>
                                            <td>{{ ceil($hitung[$i]->rata / $jum_hari) * $data->time * 2 + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time }}
                                                Item</td>
                                            <td>{{ ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time }}
                                                Item</td>
                                            <td>{{ $data->time }} hari</td>
                                            {{-- KENE --}}
                                            <td>{{ $hitung[$i]->besar }} item/hari</td>
                                            <td>{{ ceil($hitung[$i]->rata / $jum_hari) }} item/hari</td>
                                            @if ($data->stok <= ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time)
                                                <td>{{ ceil($hitung[$i]->rata / $jum_hari) * $data->time * 2 + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time - (ceil($hitung[$i]->rata / $jum_hari) * $data->time + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time) }}
                                                    Item</td>
                                                <td>
                                                    <center><span class="badge bg-danger">KRITIS</span></center>
                                                </td>
                                            @elseif (
                                                $data->stok <=
                                                    ceil($hitung[$i]->rata / $jum_hari) * $data->time +
                                                        ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time)
                                                {{-- <td>{{ ceil($hitung[$i]->rata / $jum_hari) * $data->time * 2 + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time - (ceil($hitung[$i]->rata / $jum_hari) * $data->time + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time) }}
                                                    Item</td>
                                                <td> --}}
                                                <td>{{ ceil($hitung[$i]->rata / $jum_hari) * $data->time * 2 + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time - (ceil($hitung[$i]->rata / $jum_hari) * $data->time + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time) }}
                                                    Item</td>
                                                {{-- @dd(ceil($hitung[1]->rata / $jum_hari) * $data_part[1]->time + ($hitung[1]->besar - ceil($hitung[1]->rata / $jum_hari)) * $data_part[1]->time, ceil($hitung[1]->rata / $jum_hari) * $data_part[1]->time * 2 + ($hitung[1]->besar - ceil($hitung[1]->rata / $jum_hari)) * $data_part[1]->time, ceil($hitung[1]->rata / $jum_hari) * $data_part[1]->time * 2 + ($hitung[1]->besar - ceil($hitung[1]->rata / $jum_hari)) * $data_part[1]->time - (ceil($hitung[1]->rata / $jum_hari) * $data_part[1]->time + ($hitung[1]->besar - ceil($hitung[1]->rata / $jum_hari)) * $data_part[1]->time)) --}}
                                                {{-- @dd(ceil($hitung[1]->rata / $jum_hari) * $data_part[1]->time * 2 + ($hitung[1]->besar - ceil($hitung[1]->rata / $jum_hari)) * $data_part[1]->time - (ceil($hitung[1]->rata / $jum_hari) * $data_part[1]->time + ($hitung[1]->besar - ceil($hitung[1]->rata / $jum_hari)) * $data_part[1]->time)) --}}
                                                <td>
                                                    <center><span class="badge badge-warning">RESTOCK</span></center>
                                                </td>
                                            @else
                                                <td>
                                                    {{ ceil($hitung[$i]->rata / $jum_hari) * $data->time * 2 + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time - (ceil($hitung[$i]->rata / $jum_hari) * $data->time + ($hitung[$i]->besar - ceil($hitung[$i]->rata / $jum_hari)) * $data->time) }}
                                                    Item
                                                </td>
                                                <td>
                                                    <center><span class="badge badge-success">AMAN</span></center>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('head')
        <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    @endpush

    @push('head')
        <style>
            .bg-danger {
                background-color: red;
            }

            .badge-warning {
                background-color: yellow;
            }

            .badge-success {
                background-color: green;
            }
        </style>
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
