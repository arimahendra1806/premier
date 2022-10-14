@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Konfirmasi Pembayaran')
<?php $subtitle="Konfirmasi Pembayaran"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')<!-- 
https://meritocracy.is/blog/2020/04/17/laravel-using-pagination-sorting-and-filtering-with-your-tables/ -->
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Konfirmasi Pembayaran</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            @include('flash-message')
            <div class="row">
              <div class="col-lg-12">
                <div class="block margin-bottom-sm">
                  <div class="title"><strong>Konfirmasi Pembayaran Lapangan Premier Futsal Kediri</strong></div>
			          <div class="search-inner" style="">
			            <form action="/admin/konfirmasi/search" method="POST">
			            	@csrf
                    <div class="input-group mb-3 col-md-4 float-right">
                      <input class="form-control" type="text" id="cariId" name="cariId" value="{{old('cariId')}}" placeholder="Ketikan kode transaksi" style="">
                      <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Search</button>
                        </div>
                      <!-- <button type="submit" class="submit btn-search-1-1"><b>Search</b></button> -->
                    </div>
			              <!-- <div class="form-group">
			                <input type="text" id="cariId" name="cariId" placeholder="Ketikan kode transaksi" value="{{old('cari')}}">
			                <button type="submit" class="submit btn-search-1-1"><b>Search</b></button>
			              </div> -->
			            </form>
			          </div>
                  <div class="table-responsive"> 
                    <table class="table" id="myTable" width="100%">
                      <thead>
                        <tr>
                          <th>@sortablelink('loop','#')</th>
                          <th>@sortablelink('id_transaksi','ID Booking')</th>
                          <th>@sortablelink('member.nama_lengkap','Pemesan')</th>
                          <th>@sortablelink('tanggal_booking','Tanggal Booking')</th>
                          <th>@sortablelink('total_booking','Total Booking')</th>
                          <th>@sortablelink('status_booking','Status Booking')</th>
                          <th>@sortablelink('Aksi')</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
	                        @forelse($data as $ndata)
	                            <tr>
	                                <td>{{$loop->iteration + $data->firstItem()-1}}</td>
	                                <td>{{$ndata->id_transaksi}}</td>
	                                <td>{{$ndata->member->nama_lengkap}}</td>
	                                <td>{{date('d M Y', strtotime($ndata->tanggal_booking))}}</td>
	                                <td>{{$ndata->total_booking}}</td>
	                                <td>{{$ndata->status_booking}}</td>
                                  <td>
                                    <a class="btn btn-warning" 
                                        href="/admin/editKonfirmasi/{{$ndata->id_transaksi}}" role="button">
                                        Edit      
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
