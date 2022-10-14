@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Cara Pembayaran')<!-- 
<?php $subtitle="Detail Nota"; ?> -->

<!-- Section untuk content -->
@section('content')<!-- 
https://meritocracy.is/blog/2020/04/17/laravel-using-pagination-sorting-and-filtering-with-your-tables/ -->
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Detail Pembayaran</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              @foreach ($data as $ndata)
              @if($ndata->pembayaran == "LinkAja")
              <div class="col-lg-6" style="float:none;margin:auto;">
                <div class="messages-block block">
                  <span style="text-align: center; display: block;">
                    <img src="../../assets/images/premier/Logo Link Aja!.png" style="width: 450px; height: 325px;">
                  </span>
                  <div class="title" style="text-align: center;">
                    <strong>Link Aja</strong>
                  </div>
                  <div class="container-fluid">
                    <hr>
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col">
                            <h6>ID Transaksi</h6>
                          </div>
                           <div class="col">
                            <h6>{{$ndata->id_transaksi}}</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>Tanggal Booking</h6>
                          </div>
                           <div class="col">
                            <h6>{{date('d M Y', strtotime($ndata->tanggal_booking))}}</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>Jam Booking</h6>
                          </div>
                           <div class="col">
                            <h6>{{date('H:i', strtotime($ndata->jam_masuk))}} - {{date('H:i', strtotime($ndata->jam_keluar))}}</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>Total Bayar</h6>
                          </div>
                           <div class="col">
                            <h6>Rp. {{$ndata->total_booking}},-</h6>
                          </div>
                        </div>
                      </div>
                    <hr>
                    <div class="container-fluid">
                      <p style="text-align: justify;">
                        Lakukan segera transaksi dengan total yang telah ditentukan. Dengan cara transfer ke nomor akun LinkAja, dalam kurun waktu 1 jam.
                      </p>
                      <div class="container-fluid" style="padding-left: 3em">
                        <div class="row">
                          <div class="col">
                            <h6>Atasnama</h6>
                          </div>
                           <div class="col">
                            <h6>Premier Futsal</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>No. LinkAja</h6>
                          </div>
                           <div class="col">
                            <h6>081222333444</h6>
                          </div>
                        </div>
                      </div>
                      <p style="text-align: justify;">
                        *NB : Konfirmasi pembayaran dilakukan oleh admin, dengan masa waktu 30 menit, dan pastikan tambhakan ID Transaksi pada note saat melakukan transfer pembayaran
                      </p>
                  </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="row">
              @else
              <div class="col-lg-6" style="float:none;margin:auto;">
                <div class="messages-block block">
                  <span style="text-align: center; display: block;">
                    <img src="../../assets/images/premier/logo-ovo.png" style="width: 350px; height: 225px;">
                  </span>
                  <div class="title" style="text-align: center;">
                    <strong>Ovo</strong>
                  </div>
                  <div class="container-fluid">
                    <hr>
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col">
                            <h6>ID Transaksi</h6>
                          </div>
                           <div class="col">
                            <h6>{{$ndata->id_transaksi}}</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>Tanggal Booking</h6>
                          </div>
                           <div class="col">
                            <h6>{{date('d M Y', strtotime($ndata->tanggal_booking))}}</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>Jam Booking</h6>
                          </div>
                           <div class="col">
                            <h6>{{date('H:i', strtotime($ndata->jam_masuk))}} - {{date('H:i', strtotime($ndata->jam_keluar))}}</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>Total Bayar</h6>
                          </div>
                           <div class="col">
                            <h6>Rp. {{$ndata->total_booking}},-</h6>
                          </div>
                        </div>
                      </div>
                    <hr>
                    <div class="container-fluid">
                      <p style="text-align: justify;">
                        Lakukan segera transaksi dengan total yang telah ditentukan. Dengan cara transfer ke nomor akun Ovo, dalam kurun waktu 1 jam.
                      </p>
                      <div class="container-fluid" style="padding-left: 3em">
                        <div class="row">
                          <div class="col">
                            <h6>Atasnama</h6>
                          </div>
                           <div class="col">
                            <h6>Premier Futsal</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <h6>No. Ovo</h6>
                          </div>
                           <div class="col">
                            <h6>081222333444</h6>
                          </div>
                        </div>
                      </div>
                      <p style="text-align: justify;">
                        *NB : Konfirmasi pembayaran dilakukan oleh admin, dengan masa waktu 30 menit, dan pastikan tambahkan ID Transaksi pada note saat melakukan transfer pembayaran
                      </p>
                  </div>
                  </div>
                </div>
              </div>
             </div>
             @endif
             @endforeach
           </div>
      </section>
@endsection