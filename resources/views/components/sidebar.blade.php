 <aside class="main-sidebar">
     <section class="sidebar">
         <div class="user-panel">
             <div class="pull-left image">
                 <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
             </div>

             <div class="pull-left info">
                 <p>{{ auth()->user()->name }}</p>
                 <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
             </div>
         </div>

         <ul class="sidebar-menu" data-widget="tree">
             <li class="header">MENU DATA MASTER</li>

             {{-- <li class="{{ $active == 'dashboard' ? 'active' : '' }}">
                 <a href="{{ route('dashboard.index') }}">
                     <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                 </a>
             </li> --}}

             <li class="{{ $active == 'supplier' ? 'active' : '' }}">
                 <a href="{{ route('supplier.index') }}">
                     <i class="fa fa fa-truck"></i> <span> Supplier</span>
                 </a>
             </li>

             <li class="{{ $active == 'customer' ? 'active' : '' }}">
                 <a href="{{ route('customer.index') }}">
                     <i class="fa fa-users"></i> <span> Customer</span>
                 </a>
             </li>

             <li class="treeview {{ $active == 'product' ? 'active' : '' }}">
                 <a href="#">
                     <i class="fa fa-archive"></i>
                     <span> Gudang</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                     </span>
                 </a>

                 <ul class="treeview-menu">
                     <li class="{{ $active_detail == 'categories' ? 'active' : '' }}">
                         <a href="{{ route('product.categories.index') }}"><i class="fa fa-circle-o"></i> Kategori</a>
                     </li>
                     <li class="{{ $active_detail == 'items' ? 'active' : '' }}">
                         <a href="{{ route('product.items.index') }}"><i class="fa fa-circle-o"></i> Sparepart</a>
                     </li>
                 </ul>
             </li>

             <li class="header">MENU TRANSAKSI</li>
             <li class="treeview {{ $active == 'restock' ? 'active' : '' }}">
                 <a href="#">
                     <i class="fa fa-truck"></i>
                     <span> Restock</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                     </span>
                 </a>

                 <ul class="treeview-menu">
                     <li class="{{ $active_detail == 'pembelian' ? 'active' : '' }}">
                         <a href="{{ route('restock.pembelian.index') }}"><i class="fa fa-circle-o"></i>
                             Pembelian</a>
                     </li>

                     <li class="{{ $active_detail == 'penerimaan' ? 'active' : '' }}">
                         <a href="{{ route('restock.penerimaan.index') }}"><i class="fa fa-circle-o"></i>
                             Penerimaan</a>
                     </li>
                 </ul>
             </li>

             @if (auth()->user()->level == 2)
                 <li class="{{ $active == 'transaction' ? 'active' : '' }}">
                     <a href="{{ route('service.sales.index') }}">
                         <i class="fa fa-shopping-cart"></i> <span> Kirim Barang</span>
                     </a>
                 </li>
             @endif

             <li class="header"> MENU PERHITUNGAN MIN MAX</li>
             <li class="treeview {{ $active == 'min-max' ? 'active' : '' }}">
                 <a href="#">
                     <i class="fa fa-book"></i>
                     <span> Min Max</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                     </span>
                 </a>

                 <ul class="treeview-menu">
                     <li class="{{ $active_detail == 'realtime' ? 'active' : '' }}">
                         <a href="{{ route('min-max.realtime.index') }}"><i class="fa fa-circle-o"></i> Real Time</a>
                     </li>

                     <li class="{{ $active_detail == 'periode' ? 'active' : '' }}">
                         <a href="{{ route('min-max.periode.index') }}"><i class="fa fa-circle-o"></i> Periode
                             Berikutnya
                         </a>
                     </li>
                 </ul>
             </li>

             @if (auth()->user()->level == 1)
                 <li class="header"> MENU LAPORAN</li>
                 <li class="treeview {{ $active == 'laporan' ? 'active' : '' }}">
                     <a href="#">
                         <i class="fa fa-history"></i>
                         <span> Laporan</span>
                         <span class="pull-right-container">
                             <i class="fa fa-angle-left pull-right"></i>
                         </span>
                     </a>

                     <ul class="treeview-menu">
                         <li class="{{ $active_detail == 'transaction service' ? 'active' : '' }}">
                             <a href="{{ route('laporan.transaction.index') }}"><i class="fa fa-circle-o"></i> Laporan
                                 Transaksi Service</a>
                         </li>

                         <li class="{{ $active_detail == 'pembelian' ? 'active' : '' }}">
                             <a href="{{ route('laporan.pembelian.index') }}"><i class="fa fa-circle-o"></i> Laporan
                                 Pembelian
                             </a>
                         </li>

                         <li class="{{ $active_detail == 'penerimaan' ? 'active' : '' }}">
                             <a href="{{ route('laporan.penerimaan.index') }}"><i class="fa fa-circle-o"></i> Laporan
                                 Penerimaan
                             </a>
                         </li>
                     </ul>
                 </li>
             @endif
         </ul>
     </section>
 </aside>
