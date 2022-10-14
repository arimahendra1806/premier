@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Laporan Bulanan')
<?php $subtitle="Laporan Offline"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Laporan Bulanan Booking Offline</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="block margin-bottom-sm">
                  <div class="title"><strong>Laporan Bulanan Lapangan Premier Futsal Kediri</strong></div>
			          <div class="search-inner">
                  <form action="/admin/laporan" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                      <input type="text" id="created_at" name="date" class="form-control">
                        <!-- <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Filter</button>
                        </div> -->
                        <a target="_blank" class="btn btn-utama text-white" id="exportpdf">Export PDF</a>
                    </div>
                  </form>
			          </div>
                  <div class="table-responsive">
                    <table class="table" id="myTable" width="100%">
                      <thead>
                        <tr>
                          <th>@sortablelink('loop','#')</th>
                          <th>@sortablelink('id_transaksi','Id Transaksi')</th>
                          <th>@sortablelink('tanggal_booking','Tanggal Booking')</th>
                          <th>@sortablelink('jam_masuk','Jam Masuk')</th>
                          <th>@sortablelink('jam_keluar','Jam Keluar')</th>
                          <th>@sortablelink('member.nama_lengkap','Pemesan')</th>
                          <th>@sortablelink('Aksi')</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
	                        @forelse($data as $ndata)
	                            <tr>
	                                <td>{{$loop->iteration + $data->firstItem()-1}}</td>
	                                <td>{{$ndata->id_transaksi}}</td>
                                  <td>{{date('d M Y', strtotime($ndata->tanggal_booking))}}</td>
                                  <td>
                                    {{date('H:i', strtotime($ndata->jam_masuk))}}
                                  </td>
                                  <td>
                                    {{date('H:i', strtotime($ndata->jam_keluar))}}
                                  </td>
                                  <td>{{$ndata->member_offline}}</td>
                                  <td>
                                    <a class="btn btn-info"
                                        href="/admin/showLaporanOffline/{{$ndata->id_transaksi}}" role="button">
                                        Show
                                    </a>
                                  </td>
	                            </tr>
	                        @empty
                              <tr>
                                  <td colspan="10" style="text-align: center">Data Tidak Ada</td>
                              </tr>
                          @endforelse
                        </tr>
                      </tbody>
                    </table>
      				{!! $data->links('vendor.pagination.bootstrap-4') !!}
                  </div>
                </div>
              </div>
             </div>
           </div>
      </section>
@endsection

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
     <script>
          //KETIKA PERTAMA KALI DI-LOAD MAKA TANGGAL NYA DI-SET TANGGAL SAA PERTAMA DAN TERAKHIR DARI BULAN SAAT INI
          $(document).ready(function() {
              let start = moment().startOf('month')
              let end = moment().endOf('month')

              //KEMUDIAN TOMBOL EXPORT PDF DI-SET URLNYA BERDASARKAN TGL TERSEBUT
              $('#exportpdf').attr('href', '/admin/laporanOffline/pdf/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

              //INISIASI DATERANGEPICKER
              $('#created_at').daterangepicker({
                  startDate: start,
                  endDate: end
              }, function(first, last) {
                  //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
                  $('#exportpdf').attr('href', '/admin/laporanOffline/pdf/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
              })
          })
      </script>
@endpush
