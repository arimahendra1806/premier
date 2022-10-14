@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Riwayat Transaksi Toko')
<?php $subtitle="Riwayat Toko"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Riwayat Transasksi</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="block margin-bottom-sm">
                  <div class="title"><strong>Riwayat Transaksi Toko Premier Futsal Kediri</strong></div>
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
                          <th>@sortablelink('invoices_number','Nomor Invoices')</th>
                          <th>@sortablelink('admin.nama_lengkap','Admin')</th>
                          <th>@sortablelink('pay','Bayar')</th>
                          <th>@sortablelink('total','Total')</th>
                          {{-- <th>@sortablelink('','Pemesan')</th> --}}
                          <th>@sortablelink('Aksi')</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            @forelse ($history as $index=>$item)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$item->invoices_number}}</td>
                                <td>{{$item->admin->nama_lengkap}}</td>
                                <td>{{$item->pay}}</td>
                                <td>{{$item->total}}</td>
                                <td><a href="{{url('/transcation/laporan', $item->invoices_number )}}" class="btn btn btn-info">Detail</i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" style="text-align: center">Data Tidak Ada</td>
                            </tr>
                            @endforelse
                        </tr>
                      </tbody>
                    </table>
      				{!! $history->links('vendor.pagination.bootstrap-4') !!}
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
              $('#exportpdf').attr('href', '/transcation/laporanToko/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

              //INISIASI DATERANGEPICKER
              $('#created_at').daterangepicker({
                  startDate: start,
                  endDate: end
              }, function(first, last) {
                  //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
                  $('#exportpdf').attr('href', '/transcation/laporanToko/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
              })
          })
      </script>
@endpush
