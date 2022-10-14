@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Dashboard')
<?php $subtitle="Dashboard"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            @if(Auth::check() && Auth::user()->role == "admin")
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
            @else
            <h2 class="h5 no-margin-bottom">Informasi Lapangan</h2>
            @endif
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
          @if(Auth::check() && Auth::user()->role == "admin")
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4 col-sm-8">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-user-1"></i></div><strong>Member Premier</strong>
                    </div>
                    <div class="number dashtext-2">{{$dataMem}}</div>
                  </div>
                  <div class="progress progress-template">
                    @php $countMember= $dataMem * 2; @endphp
                    <div role="progress-bar" style="width: <?php echo $countMember ?>%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2">
                  </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-8">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-new-file"></i></div><strong>Semua Transaksi Booking</strong>
                    </div>
                    <div class="number dashtext-3">{{$dataTrx}}</div>
                  </div>
                  <div class="progress progress-template">
                    @php $countdataTrx= $dataTrx * 2; @endphp
                    <div role="progressbar" style="width: <?php echo $countdataTrx ?>%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4   col-sm-8">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-cloud"></i></div><strong>Transaksi Sukses</strong>
                    </div>
                    <div class="number dashtext-3">{{$dataTrxSs}}</div>
                  </div>
                  <div class="progress progress-template">
                    @php $countdataTrxSs= $dataTrxSs * 2; @endphp
                    <div role="progressbar" style="width: <?php echo $countdataTrxSs ?>%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="500" class="progress-bar progress-bar-template dashbg-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="stats-3-block block d-flex">
                <div class="stats-3"><strong class="d-block">{{$dataTrxMem}}</strong><span class="d-block">Menunggu Konfirmasi</span>
                    <div class="progress progress-template">
                      @php $countdataTrxMem= $dataTrxMem * 4; @endphp
                      <div role="progressbar" style="width: <?php echo $countdataTrxMem ?>%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                    </div>
                  </div>
                  <div class="stats-3 d-flex justify-content-between text-center">
                    <div class="item"><strong class="d-block strong-sm">{{$dataTrxMem1}}</strong>
                      <span class="d-block span-sm">Lapangan 1</span>
                    </div>
                    <div class="item"><strong class="d-block strong-sm">{{$dataTrxMem2}}</strong>
                      <span class="d-block span-sm">Lapangan 2</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="stats-3-block block d-flex">
                <div class="stats-8 mb-2">
                  <span class="d-block">Pendapatan Online Bulan Ini</span>
                  <img src="../../assets/images/premier/3d3c17b1d6ad8af2cff0d6b8c2743dd4-removebg-preview.png" style="width: 100px; height: 50px; padding-top: 0,5em; margin-top: 0.2em;"><span><h3><strong">{{$dataTotal}},-</strong></h3></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="stats-3-block block d-flex">
                <div class="stats-8 mb-2">
                  <span class="d-block">Pendapatan Offline Bulan Ini</span>
                  <img src="../../assets/images/premier/3d3c17b1d6ad8af2cff0d6b8c2743dd4-removebg-preview.png" style="width: 100px; height: 50px; padding-top: 0,5em; margin-top: 0.2em;"><span><h3><strong">{{$dataTotal2}},-</strong></h3></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="stats-3-block block d-flex">
                <div class="stats-8 mb-2">
                  <span class="d-block">Pendapatan Toko Bulan Ini</span>
                  <img src="../../assets/images/premier/3d3c17b1d6ad8af2cff0d6b8c2743dd4-removebg-preview.png" style="width: 100px; height: 50px; padding-top: 0,5em; margin-top: 0.2em;"><span><h3><strong">{{$dataTotal3}},-</strong></h3></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="no-padding-bottom">
          @else
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="messages-block block">
                  @foreach($lap1 as $lap1)
                    <img src="../../assets/images/premier/{{$lap1->foto_lapangan}}" style="width: 445px; height: 325px;">
                  @endforeach
                  <div class="title" style="text-align: center; padding-top: 1em;">
                    <strong>Lapangan Sintetis</strong><br>
                    <strong>
                    @foreach($hargaA as $i)
                        Rp. {{$i->harga}},-
                      </strong>
                      <p style="text-align: justify;">{{$i->keterangan}}</p>
                    @endforeach
                  </div>
                  <div style="text-align: center;">
                    <a class="btn btn-danger"
                      href="/member/createBooking" role="button">
                      Pesan Sekarang
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="messages-block block">
                  @foreach($lap2 as $lap2)
                    <img src="../../assets/images/premier/{{$lap2->foto_lapangan}}" style="width: 445px; height: 325px;">
                  @endforeach
                  <div class="title" style="text-align: center; padding-top: 1em;">
                    <strong>Lapangan Vinyl</strong><br>
                    <strong>
                      @foreach($hargaB as $j)
                        Rp. {{$j->harga}},-
                    </strong>
                    <p style="text-align: justify;">{{$j->keterangan}}</p>
                    @endforeach
                  </div>
                  <div style="text-align: center;">
                    <a class="btn btn-danger"
                      href="/member/createBooking" role="button">
                      Pesan Sekarang
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
        </section>
@endsection
