@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Daftar Booking')
<?php $subtitle="Daftar Booking"; ?>

<!-- Section untuk content -->
@section('content')<!--
https://meritocracy.is/blog/2020/04/17/laravel-using-pagination-sorting-and-filtering-with-your-tables/ -->
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Daftar Booking</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="block margin-bottom-sm">
                  <div class="title"><strong>Daftar Semua Booking Lapangan Premier Futsal Kediri</strong></div>
			          <div class="search-inner" style="">
			            <form action="/member/search" method="POST">
			            	@csrf
                    <a href="/member/createBooking" type="button" class="btn btn-info float-left">[+] Booking</a>
			              <div class="input-group mb-3 col-md-4 float-right">
			                <input class="form-control" type="date" id="cari" name="cari" value="{{old('cari')}}" style="">
                      <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">Search</button>
                      </div>
			              </div>
			            </form>
			          </div>
                  <div class="table-responsive">
                    <table class="table" id="myTable" width="100%">
                      <thead>
                        <tr>
                          <th>@sortablelink('loop','#')</th>
                          <th>@sortablelink('tanggal_booking','Tanggal Booking')</th>
                          <th>@sortablelink('jam_masuk','Jam Masuk')</th>
                          <th>@sortablelink('jam_keluar','Jam Keluar')</th>
                          <th>@sortablelink('lapangan.nama_lapangan','Lapangan')</th>
                          <th>@sortablelink('member.nama_lengkap','Pemesan')</th>
                          <th>@sortablelink('status_booking','Status Booking')</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
	                        @forelse($data as $ndata)
	                            <tr>
	                                <td>{{$loop->iteration + $data->firstItem()-1}}</td>
                                  <td>{{date('d M Y', strtotime($ndata->tanggal_booking))}}</td>
                                  <td>
                                    {{date('H:i', strtotime($ndata->jam_masuk))}}
                                  </td>
                                  <td>
                                    {{date('H:i', strtotime($ndata->jam_keluar))}}
                                  </td>
	                                <td>Lapangan {{$ndata->lapangan->jenis->jenis_lapangan}}</td>
	                                <td>
                                        @if ($ndata->member->nama_lengkap == 'Offline')
                                            {{$ndata->member_offline}}
                                        @else
                                            {{$ndata->member->nama_lengkap}}
                                        @endif
                                    </td>
	                                <td>{{$ndata->status_booking}}</td>
	                            </tr>
	                        @empty
                                <tr>
                                    <td colspan="10" style="text-align: center">Data Tidak Ada</td>
                                </tr>
                          @endforelse
                        </tr>
                      </tbody>
                    </table>
                    <!-- {!! $data->appends(Request::except('page'))->render() !!} -->
      				{!! $data->links('vendor.pagination.bootstrap-4') !!}
                  </div>
                </div>
              </div>
             </div>
           </div>
      </section>
@endsection
