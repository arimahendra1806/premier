@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Profile Member')
<?php $subtitle="Profile Member"; ?>

<!-- Section untuk content -->
@section('content')<!-- 
https://meritocracy.is/blog/2020/04/17/laravel-using-pagination-sorting-and-filtering-with-your-tables/ -->
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Profile Member</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            @include('flash-message')
            <div class="row">
              <div class="col-lg-5">
                <div class="messages-block block">
                  <br><br><br>
                  <span style="text-align: center; display: block;">
                    <img src="../../assets/images/premier/payment-removebg-preview(1).png" style="width: 150px; height: 109px;">
                  </span>
                  <div class="title" style="text-align: center; padding-top: 1em;">
                    <strong style="text-transform: capitalize;">{{ Auth::user()->nickname }}</strong><br>
                    <strong>{{ Auth::user()->email }}</strong>
                  </div>
                  <span>
                    <p id="rcorners2">{{$dataTrx}} Transaksi</p>
                  </span>
                  <br><br><br>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="messages-block block">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="title"><strong class="d-block">Detail Profil Member</strong></div>
                      </div>
                    </div>
                    @forelse($data as $ndata)
                      <div class="row">
                        <div class="col-lg-8">
                          <label class="form-control-label">Nama</label>
                          <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="{{$ndata->nama_lengkap}}" value="" disabled>
                        </div>
                      </div>
                      <input type="text" id="id_user" name="id_user" class="form-control" value="{{$ndata->id_user}}" hidden="">
                      <div class="row">
                        <div class="col-lg-8">
                          <label class="form-control-label">Alamat</label>
                          <input type="text" id="alamat" name="alamat" class="form-control" placeholder="{{$ndata->alamat}}" value="" disabled>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-8">
                          <label class="form-control-label">No. Telepon</label>
                          <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="{{$ndata->no_hp}}" value="" disabled>
                        </div>
                      </div><br>
                      <div class="row"><!-- 
                        <div class="col-lg-7">
                          <input id="myOption" type="checkbox">
                          <label for="option">Checklist to edit profile</label>
                        </div> -->
                        <div class="col-lg-12">
                          <a class="btn btn-warning float-right" 
                            href="/member/editProfile/{{$ndata->id_member}}" role="button">
                            Edit      
                          </a>
                        </div>
                      </div>
                      @empty
                      <div class="row">
                        <div class="col-lg-12">
                          <h4 style="color: red;">Belum Melakukan Perbaharui Detail Member</h4>
                        </div>
                      </div>
                      <div class="row"><!-- 
                        <div class="col-lg-7">
                          <input id="myOption" type="checkbox">
                          <label for="option">Checklist to edit profile</label>
                        </div> -->
                        <div class="col-lg-12">
                          <a class="btn btn-info float-right" 
                            href="/member/createBooking" role="button">
                            Perbaharui Sekarang      
                          </a>
                        </div>
                      </div>
                    @endforelse
                  </form>
                  </div>
                </div>
              </div>
             </div>
             <div class="row">
               <div class="col-lg-12">
                 <div class="block">
                   <div class="title"><strong>Riwayat Transaksi</strong></div>
                   <div class="table-responsive"> 
                    <table class="table" id="myTable" width="100%">
                      <thead>
                        <tr>
                          <th>@sortablelink('loop','#')</th>
                          <th>@sortablelink('id_transaksi','Id Transaksi')</th>
                          <th>@sortablelink('tanggal_booking','Tanggal Booking')</th>
                          <th>@sortablelink('jam_masuk','Jam Booking')</th>
                          <th>@sortablelink('status_booking','Status')</th>
                          <th>@sortablelink('Bukti')</th>
                          <th>@sortablelink('Aksi')</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          @forelse($dataRw as $ndata)
                              <tr>
                                  <td>{{$loop->iteration + $dataRw->firstItem()-1}}</td>
                                  <td>{{$ndata->id_transaksi}}</td>
                                  <td>{{date('d M Y', strtotime($ndata->tanggal_booking))}}</td>
                                  <td>
                                    {{date('H:i', strtotime($ndata->jam_masuk))}} - {{date('H:i', strtotime($ndata->jam_keluar))}}
                                  </td>
                                  <td>{{$ndata->status_booking}}</td>
                                  <td>
                                    @if($ndata->bukti_bayar === Null)
                                      <span><img src="../../assets/images/premier/unverified-account.png" style="width: 30px; height: 30px;"></span>
                                    @else
                                      <span><img src="../../assets/images/premier/twitter-verified-badge.svg" style="width: 30px; height: 30px;"></span>
                                    @endif
                                  </td>
                                  @if($ndata->status_booking != "Menunggu")
                                  <td>
                                    <a class="btn btn-danger" 
                                        href="/member/profile/cetak/{{$ndata->id_transaksi}}" role="button">
                                        Cetak      
                                    </a>
                                  </td>
                                  @else
                                  <td>
                                    @if($ndata->bukti_bayar === Null)
                                    <a class="btn btn-info" 
                                        href="/member/caraPembayaran/{{$ndata->id_transaksi}}" role="button">
                                        Detail      
                                    </a> | 
                                    <a class="btn btn-warning" 
                                        href="/member/editBukti/{{$ndata->id_transaksi}}" role="button">
                                        Upload Bukti      
                                    </a>
                                    @else
                                    <a class="btn btn-info" 
                                        href="/member/caraPembayaran/{{$ndata->id_transaksi}}" role="button">
                                        Detail      
                                    </a>
                                    @endif
                                  </td>
                                  @endif
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="10" style="text-align: center">Data Tidak Ada</td>
                              </tr>
                          @endforelse
                        </tr>
                      </tbody>
                    </table>
              {!! $dataRw->links('vendor.pagination.bootstrap-4') !!}
                  </div>
                 </div>
               </div>
             </div>
           </div>
      </section>
@endsection

@push('js')
  <style type="text/css">
    #rcorners2 {
      border-radius: 25px;
      border: 2px solid #73AD21;
      padding: 10px; 
      width: 200px;
      height: 50px; 
      text-align: center;
      color: #FFFFFF;
      position: absolute;
      top: 75%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
  <script type="text/javascript">
    // document.getElementById('myOption').onchange = function() {
    //     document.getElementById('nama_lengkap').disabled = !this.checked;
    //     document.getElementById('alamat').disabled = !this.checked;
    //     document.getElementById('no_hp').disabled = !this.checked;
    // };
  </script>
@endpush