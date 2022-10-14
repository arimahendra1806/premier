<div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="../../img/PicsArt_03-22-12.49.04.jpg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h4" style="text-transform: capitalize;">{{ Auth::user()->nickname }}</h1>
            <p style="text-transform: capitalize;">{{ Auth::user()->role }}</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus-->
        <ul class="list-unstyled">
          @if(Auth::check() && Auth::user()->role == "admin")
          <span class="heading">Menu Admin</span>
            <li class="<?php if($subtitle == "Dashboard"){echo "active";} ?>"><a href="/dashboard"> <i class="icon-dashboard"></i>Dashboard </a></li>
            <li class="<?php if($subtitle == "Informasi Booking"){echo "active";} ?>"><a href="/admin/index"> <i class="icon-padnote"></i>Informasi Booking</a></li>
            <li class="<?php if($subtitle == "Konfirmasi Pembayaran"){echo "active";} elseif($subtitle == "Laporan Bulanan"){echo "active";}?>">
              <a href="#bookingOnline" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Booking Online</a>
              <ul id="bookingOnline" class="collapse list-unstyled ">
                <li class="<?php if($subtitle == "Konfirmasi Pembayaran"){echo "active";} ?>">
                  <a href="/admin/konfirmasi">Konfirmasi Pembayaran</a>
                </li>
                <li class="<?php if($subtitle == "Laporan Bulanan"){echo "active";} ?>">
                  <a href="/admin/laporan">Riwayat & Laporan</a>
                </li>
              </ul>
            </li>
            <li class="<?php if($subtitle == "Transaksi Offline"){echo "active";} elseif($subtitle == "Laporan Offline"){echo "active";} ?>"><a href="#bookingOffline" aria-expanded="false" data-toggle="collapse"> <i class="icon-contract"></i>Booking Offline</a>
              <ul id="bookingOffline" class="collapse list-unstyled ">
                <li class="<?php if($subtitle == "Transaksi Offline"){echo "active";} ?>">
                  <a href="/admin/bookingOffline">Transaksi Offline</a>
                </li>
                <li class="<?php if($subtitle == "Laporan Offline"){echo "active";} ?>">
                  <a href="/admin/laporanOffline">Riwayat & Laporan</a>
                </li>
              </ul>
            </li>
            <span class="heading mt-4">Menu Toko</span>
            <li class="<?php if($subtitle == "Transaksi Toko"){echo "active";} ?>"><a href="/transcation"> <i class="icon-dashboard"></i>Transaksi Toko</a></li>
            <li class="<?php if($subtitle == "Riwayat Toko"){echo "active";} ?>"><a href="/transcation/history"> <i class="icon-padnote"></i>Riwayat Toko</a></li>
            <li class="<?php if($subtitle == "Produk Toko"){echo "active";} ?>"><a href="/product"> <i class="icon-check"></i>Stok Produk</a></li>
          @else
          <span class="heading">Menu Member</span>
            <li class="<?php if($subtitle == "Dashboard"){echo "active";} ?>"><a href="/dashboard"> <i class="icon-info"></i>Informasi Lapangan</a></li>
            <li class="<?php if($subtitle == "Profile Member"){echo "active";} ?>"><a href="/member/profile"> <i class="icon-user-outline"></i>Profil Member</a></li>
            <li class="<?php if($subtitle == "Daftar Booking"){echo "active";} ?>"><a href="/member/daftarBooking"> <i class="icon-padnote"></i>Daftar Booking</a></li>
            <li class="<?php if($subtitle == "Kontak Admin"){echo "active";} ?>"><a href="/member/kontakAdmin"> <i class="icon-flow-branch"></i>Kontak Admin</a></li>
          </ul>
          @endif
      </nav>
      <!-- Sidebar Navigation end-->
      {{-- TIDAK DIGUNAKAN --}}
            <!-- <li><a href="tables.html"> <i class="icon-info"></i>Informasi Lapangan</a></li> -->
            {{-- <li class="<?php if($subtitle == "Konfirmasi Pembayaran"){echo "active";} ?>"><a href="/admin/konfirmasi"> <i class="icon-check"></i>Konfirmasi Pembayaran</a></li> --}}
            {{-- <li class="<?php if($subtitle == "Laporan Bulanan"){echo "active";} ?>"><a href="/admin/laporan"> <i class="icon-bill"></i>Laporan Bulanan</a></li> --}}
            <!-- <li><a href="tables.html"> <i class="icon-info"></i>Informasi Lapangan</a></li> -->
            <!-- <li class=""><a href="/member/pesananSaya"> <i class="icon-contract"></i>Booking Lapangan</a></li> -->
            {{-- <li class="<?php if($subtitle == "Booking Offline"){echo "active";} ?>"><a href="/admin/bookingOffline"> <i class="icon-check"></i>Booking Offline</a></li> --}}
      {{-- END TIDAK DIGUNAKAN --}}
