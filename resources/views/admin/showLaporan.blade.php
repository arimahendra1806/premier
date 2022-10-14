@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Detail Transaksi')
<!-- <?php $subtitle="Detail"; ?> -->

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')<!-- 
https://meritocracy.is/blog/2020/04/17/laravel-using-pagination-sorting-and-filtering-with-your-tables/ -->
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Detail Transaksi</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <!-- Basic Form-->
              <div class="col-lg-12">
                <div class="block">
                  @foreach($data as $ndata)
                  <div class="title"><strong class="d-block">Detail Transaksi Lapangan Premier Futsal Kediri</strong>
                  <span class="d-block">Detail transaksi : {{$ndata->id_transaksi}} | An : {{$ndata->member->nama_lengkap}} </span></div>
                  <div class="block-body">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-3">
                            <label class="form-control-label">ID Transaksi</label>
                            <input type="text" id="id_transaksi" name="id_transaksi" class="form-control" value="{{$ndata->id_transaksi}}" readonly="">
                          </div>
                          <div class="col-lg-3">
                            <label class="form-control-label">ID Member</label>
                            <input type="text" id="id_member" name="id_member" class="form-control" value="{{$ndata->id_member}}" readonly="">
                          </div>
                          <div class="col-lg-3">
                            <label class="form-control-label">ID Admin</label>
                            <input type="text" id="id_admin" name="id_admin" class="form-control" value="{{$ndata->id_admin}}" readonly="">
                          </div>
                          <div class="col-lg-3">
                              <label class="form-control-label">ID Lapangan</label>
                              <input type="text" id="id_lapangan" name="id_lapangan" class="form-control" value="{{$ndata->id_lapangan}}" readonly="">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4">
                            <label class="form-control-label">Tanggal Booking</label>
                            <input type="text" id="tanggal_booking" name="tanggal_booking" class="form-control" value="{{date('d M Y', strtotime($ndata->tanggal_booking))}}" readonly="">
                          </div>
                          <div class="col-lg-4">
                            <label class="form-control-label">Jam Masuk</label>
                            <input type="text" id="jam_masuk" name="jam_masuk" class="form-control" value="{{date('H:i', strtotime($ndata->jam_masuk))}}" readonly="">
                          </div>
                          <div class="col-lg-4">
                            <label class="form-control-label">Jam Keluar</label>
                            <input type="text" id="jam_keluar" name="jam_keluar" class="form-control" value="{{date('H:i', strtotime($ndata->jam_keluar))}}" readonly="">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4">
                            <label class="form-control-label">Total Jam</label>
                            <div class="input-group">
                              <input type="text" id="total_jam" name="total_jam" class="form-control" value="{{$ndata->total_jam}}" readonly="">
                              <div class="input-group-prepend"><span class="input-group-text">Jam</span></div>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <label class="form-control-label">Harga Booking</label>
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                              <input type="text" id="harga_booking" name="harga_booking" class="form-control" value="{{$ndata->harga_booking}}" readonly="">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <label class="form-control-label">Total Booking</label>
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                              <input type="text" id="total_booking" name="total_booking" class="form-control" value="{{$ndata->total_booking}}" onkeyup="sisa()" readonly="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6">
                            <label class="form-control-label">Bukti Pembayaran</label><br>
                            <span style="text-align: center; display: block;">
                              <img src="../../assets/images/premier/{{$ndata->bukti_bayar}}" style="width: 170px; height: 320px;">
                            </span>
                          </div>
                          <div class="col-lg-6">
                            <label class="form-control-label">Total Bayar</label>
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                              <input type="text" id="total_bayar" name="total_bayar" class="form-control" value="{{$ndata->total_bayar}}" readonly="">
                            </div><br>
                            <label class="form-control-label">Sisa Bayar</label>
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                              <input type="text" id="sisa_bayar" name="sisa_bayar" class="form-control" value="{{$ndata->sisa_bayar}}" readonly="">
                            </div><br>
                            <label class="form-control-label">Pembayaran</label>
                            <input type="text" id="pembayaran" name="pembayaran" class="form-control" value="{{$ndata->pembayaran}}" readonly=""><br>
                            <label class="form-control-label">Status Pembayaran</label>
                            <input type="text" id="status_booking" name="status_booking" class="form-control" value="{{$ndata->status_booking}}" readonly="">
                          </div>
                      </div><br>
                      <div class="form-group float-right">
                        <button type="button" class="btn btn-info" onclick="btnKembali();">Kembali</button>
                      </div><br>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection

@push('js')
<script>
  function btnKembali(url){
    var x = window.open('/admin/laporan','_self');
    x.focus();
  }
</script>
@endpush
