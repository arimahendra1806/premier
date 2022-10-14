@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Booking Offline')
<?php $subtitle="Transaksi Offline"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Booking Lapangan Offline</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            @include('flash-message')
            <div class="row">
              <div class="col-lg-12">
                <div class="messages-block block">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="title"><strong class="d-block">Booking Lapangan Offline</strong></div>
                      </div>
                    </div>
                  </div>
                    <form action="/admin/bookingOffline/store" method="POST">
                    @csrf
                     <div class="form-group">
                        <div class="row">
                          <div class="col-lg-3">
                            <label class="form-control-label">ID Transaksi</label>
                            <input type="text" id="id_transaksi" name="id_transaksi" class="form-control" value="TR<?php echo(rand(100000,999999)) ?>" readonly="">
                          </div>
                          <div class="col-lg-6">
                            <label class="form-control-label">Nama Pemesan</label>
                            <input type="text" id="member_offline" name="member_offline" class="form-control" value="">
                          </div>
                          @foreach ($idadmin as $idadmin)
                            <input type="text" id="id_admin" name="id_admin" class="form-control" value="{{ $idadmin->id_admin}}" hidden="">
                          @endforeach
                          <input type="text" id="id_member" name="id_member" class="form-control" value="{{$idMember}}" hidden="">
                          <input type="text" id="id_lapangan" name="id_lapangan" class="form-control" hidden="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <!-- Radio Btn Kondisi -->
                          <div class="col-lg-3">
                            <label class="form-control-label">Lapangan Futsal</label><br>
                          </div>
                        </div>
                        <!-- Input U/ Kondisi -->
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="container">
                              <input type="radio" id="rbn-1" name="rbn" class="radio-template" value="LP1">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="container">
                              <input type="radio" id="rbn-2" name="rbn" class="radio-template" value="LP2">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="container">
                              <div class="container">
                                <label class="drinkcard-cc rbn-1" for="rbn-1"></label>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="container">
                              <div class="container">
                                <label class="drinkcard-cc rbn-2"for="rbn-2"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Input U/ Kondisi -->
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-3">
                            <label class="form-control-label">Tanggal Booking</label>
                            <input type="date" id="tanggal_booking" name="tanggal_booking" class="form-control">
                          </div>
                          <div class="col-lg-3">
                            <label class="form-control-label">Jam Masuk</label>
                            <!-- <input type="time" id="jam_masuk" name="jam_masuk" class="form-control"> -->
                              <select name="jam_masuk" id="jam_masuk" class="form-control mb-3 mb-3" onchange="getSelectValue();">
                                <option value="">-- Pilih Status --</option>
                                <option value="08:00:00">08:00</option>
                                <option value="09:00:00">09:00</option>
                                <option value="10:00:00">10:00</option>
                                <option value="11:00:00">11:00</option>
                                <option value="12:00:00">12:00</option>
                                <option value="13:00:00">13:00</option>
                                <option value="14:00:00">14:00</option>
                                <option value="15:00:00">15:00</option>
                                <option value="16:00:00">16:00</option>
                                <option value="17:00:00">17:00</option>
                                <option value="18:00:00">18:00</option>
                                <option value="19:00:00">19:00</option>
                                <option value="20:00:00">20:00</option>
                                <option value="21:00:00">21:00</option>
                                <option value="22:00:00">22:00</option>
                                <option value="23:00:00">23:00</option>
                              </select>
                          </div>
                          <div class="col-lg-3">
                            <label class="form-control-label">Jam Keluar</label>
                            <!-- <input type="time" id="jam_keluar" name="jam_keluar" class="form-control"> -->
                            <select name="jam_keluar" id="jam_keluar" class="form-control mb-3 mb-3" onchange="getSelectValue();">
                                <option value="">-- Pilih Status --</option>
                                <option value="08:00:00">08:00</option>
                                <option value="09:00:00">09:00</option>
                                <option value="10:00:00">10:00</option>
                                <option value="11:00:00">11:00</option>
                                <option value="12:00:00">12:00</option>
                                <option value="13:00:00">13:00</option>
                                <option value="14:00:00">14:00</option>
                                <option value="15:00:00">15:00</option>
                                <option value="16:00:00">16:00</option>
                                <option value="17:00:00">17:00</option>
                                <option value="18:00:00">18:00</option>
                                <option value="19:00:00">19:00</option>
                                <option value="20:00:00">20:00</option>
                                <option value="21:00:00">21:00</option>
                                <option value="22:00:00">22:00</option>
                                <option value="23:00:00">23:00</option>
                              </select>
                          </div>
                          <div class="col-lg-3">
                            <label class="form-control-label">Total Jam</label>
                            <div class="input-group">
                              <input type="text" id="total_jam" name="total_jam" class="form-control" readonly="">
                              <div class="input-group-append"><span class="input-group-text">Jam</span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4">
                            <!-- Kondisi -->
                            <label class="form-control-label">Harga Booking</label>
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                              <!-- Store Harga Booking -->
                              <input type="text" id="harga_booking" name="harga_booking" class="form-control" readonly="">
                              <!-- Input U/ Kondisi -->
                              @foreach($hrg1 as $hrg1)
                              <input type="text" id="hrgLap1" name="hrgLap1" class="form-control"value="{{$hrg1->harga}}" hidden="">
                              @endforeach
                              @foreach($hrg2 as $hrg2)
                              <input type="text" id="hrgLap2" name="hrgLap2" class="form-control"value="{{$hrg2->harga}}" hidden="">
                              @endforeach
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <!-- JS -->
                            <label class="form-control-label">Total Booking</label>
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                              <input type="text" id="total_booking" name="total_booking" class="form-control" readonly="" onkeyup="sisa()">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <label class="form-control-label">Status Pembayaran</label>
                            <select name="status_booking" id="status_booking" class="form-control mb-3 mb-3">
                              <option value="">-- Pilih Status --</option>
                              <option value="Lunas">Lunas</option>
                              <option value="DP">DP</option>
                            </select>
                          </div>
                          <input type="text" id="pembayaran" name="pembayaran" class="form-control" value="Tunai" hidden="">
                          <input type="text" id="bukti_bayar" name="bukti_bayar" class="form-control" hidden="">
                          <input type="text" id="jenis_transaksi" name="jenis_transaksi" class="form-control" value="Offline" hidden="">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <label class="form-control-label">Total Bayar</label>
                          <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                            <input type="text" id="total_bayar" name="total_bayar" class="form-control" value="" onkeyup="sisa()">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <label class="form-control-label">Sisa Bayar</label>
                          <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                            <input type="text" id="sisa_bayar" name="sisa_bayar" class="form-control" readonly>
                          </div>
                        </div>
                      </div><br>
                      <div class="form-group float-right">
<!--                         <input type="submit" value="Simpan" class="btn btn-edit-1-1"> -->
                        <button type="submit" class="btn btn-info">Booking Sekarang</button>
                      </div><br><br>
                  </form>
                </div>
              </div>
             </div>
          </div>
      </section>
@endsection

@push('js')
  <script type="text/javascript">
    //Ambil Value Radio Button Untuk Kondisi
    var rbn1 = document.getElementById('rbn-1').value
    var rbn2 = document.getElementById('rbn-2').value

    //Ambil Value Input Harga Untuk Kondisi
    var lp1 =  document.getElementById('hrgLap1').value
    var lp2 =  document.getElementById('hrgLap2').value

    //Kondisi Ketika Rb Checked 1
    $('#rbn-1').change(function(){
      if($('#rbn-1:checked').val() == 'LP1'){
        document.getElementById('id_lapangan').value = rbn1;
        document.getElementById('harga_booking').value = lp1;
        //Kondisi Apabila Rb diganti ketika Total terisi
        var cek = document.getElementById('total_jam').value
        if(cek > 0){
          var jam = document.getElementById('total_jam').value
          var harga = document.getElementById('harga_booking').value
          var subTotal = parseInt(jam) * parseInt(harga);
          document.getElementById('total_booking').value = subTotal;
        }
      }
    });
    //Kondisi Ketika Rb Checked 2
    $('#rbn-2').change(function(){
      if($('#rbn-2:checked').val() == 'LP2'){
        document.getElementById('id_lapangan').value = rbn2;
        document.getElementById('harga_booking').value = lp2;
        //Kondisi Apabila Rb diganti ketika Total terisi
        var cek = document.getElementById('total_jam').value
        if(cek > 0){
          var jam = document.getElementById('total_jam').value
          var harga = document.getElementById('harga_booking').value
          var subTotal = parseInt(jam) * parseInt(harga);
          document.getElementById('total_booking').value = subTotal;
        }
      }
    });

    //Ambil Value Selected Jam Masuk - Keluar
    function getSelectValue(){
      var sel1 = document.getElementById('jam_masuk').value
      var sel2 = document.getElementById('jam_keluar').value
      var info = 'Input jam anda salah'
      var result = parseInt(sel2) - parseInt(sel1);
      //Jika result Bernilai Positif
      if(result > 0){
        //Ambil Value Jam terbaru
        document.getElementById('total_jam').value = result;
        //Total Booking
        var jam = document.getElementById('total_jam').value
        var harga = document.getElementById('harga_booking').value
        var subTotal = parseInt(jam) * parseInt(harga);
        document.getElementById('total_booking').value = subTotal;
      }
      //Jika result Bernilai Negatif
      if(result < 0){
        //Value Pesan Kesalahan
        document.getElementById('total_jam').value = info;
        document.getElementById('total_booking').value = info;
      }
    };
    function sisa() {
      var txtFirstNumberValue = document.getElementById('total_booking').value;
      var txtSecondNumberValue = document.getElementById('total_bayar').value;
      var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
      if (!isNaN(result)) {
          document.getElementById('sisa_bayar').value = result;
      }
    };
  </script>
  <style type="text/css">
    .cc-selector input{
      position: absolute;
        margin:0;padding:0;width: 0;
      height: 0;
        -webkit-appearance:none;
           -moz-appearance:none;
                appearance:none;
    }
    .rbn-1{background-image:url(../../assets/images/premier/IMG_20210214_140417.jpg);}
    .rbn-2{background-image:url(../../assets/images/premier/IMG_20210214_140456.jpg);}

    .cc-selector input:active +.drinkcard-cc{opacity: .9;}
    .cc-selector input:checked +.drinkcard-cc{
        -webkit-filter: none;
           -moz-filter: none;
                filter: none;
    }
    .drinkcard-cc{
        cursor:pointer;
        background-size:contain;
        width:322px;height:181px;
        -webkit-transition: all 100ms ease-in;
           -moz-transition: all 100ms ease-in;
                transition: all 100ms ease-in;
    }
    .drinkcard-cc:hover{
        outline: 2px solid #f00;
    }
  </style>
@endpush
