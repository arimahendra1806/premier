@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Edit Bukti Bayar')<!--
<?php $subtitle="Edit Bukti Bayar"; ?> -->

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Upload Bukti</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="messages-block block">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="title"><strong class="d-block">Upload Bukti Pembayaran Anda</strong></div>
                      </div>
                    </div>
                    @foreach ($data as $ndata)
                    <form action="/member/updateBukti/{{$ndata->id_transaksi}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="file-upload">
                          <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                          <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' id="bukti_bayar" name="bukti_bayar" onchange="readURL(this);" accept="image/*" />
                            <div class="drag-text">
                              <h3>Drag and drop a file or select add Image</h3>
                            </div>
                          </div>
                          <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                              <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <input type="text" id="id_member" name="id_member" class="form-control" placeholder="" value="{{$ndata->id_member}}" hidden="">
                          <input type="text" id="id_admin" name="id_admin" class="form-control" placeholder="" value="{{$ndata->id_admin}}" hidden="">
                          <input type="text" id="id_lapangan" name="id_lapangan" class="form-control" placeholder="" value="{{$ndata->id_lapangan}}" hidden="">
                          <input type="text" id="tanggal_booking" name="tanggal_booking" class="form-control" placeholder="" value="{{$ndata->tanggal_booking}}" hidden="">
                          <input type="text" id="jam_masuk" name="jam_masuk" class="form-control" placeholder="" value="{{$ndata->jam_masuk}}" hidden="">
                          <input type="text" id="jam_keluar" name="jam_keluar" class="form-control" placeholder="" value="{{$ndata->jam_keluar}}" hidden="">
                          <input type="text" id="total_jam" name="total_jam" class="form-control" placeholder="" value="{{$ndata->total_jam}}" hidden="">
                          <input type="text" id="harga_booking" name="harga_booking" class="form-control" placeholder="" value="{{$ndata->harga_booking}}" hidden="">
                          <input type="text" id="total_booking" name="total_booking" class="form-control" placeholder="" value="{{$ndata->total_booking}}" hidden="">
                          <input type="text" id="total_bayar" name="total_bayar" class="form-control" placeholder="" value="{{$ndata->total_bayar}}" hidden="">
                          <input type="text" id="sisa_bayar" name="sisa_bayar" class="form-control" placeholder="" value="{{$ndata->sisa_bayar}}" hidden="">
                          <input type="text" id="pembayaran" name="pembayaran" class="form-control" placeholder="" value="{{$ndata->pembayaran}}" hidden="">
                          <input type="text" id="status_booking" name="status_booking" class="form-control" placeholder="" value="{{$ndata->status_booking}}" hidden="">
                        </div>
                      </div>
                      <div class="row float-right">
                        <div class="col-lg-12">
                          <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                      </div><br>
                      @endforeach
                    </form>
                  </div>
                </div>
              </div>
             </div>
           </div>
      </section>
@endsection

@push('js')
  <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script type="text/javascript">

    function readURL(input) {
      if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
          $('.image-upload-wrap').hide();

          $('.file-upload-image').attr('src', e.target.result);
          $('.file-upload-content').show();

          $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

      } else {
        removeUpload();
      }
    }

    function removeUpload() {
      $('.file-upload-input').replaceWith($('.file-upload-input').clone());
      $('.file-upload-content').hide();
      $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
      });
      $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
  </script>
  <style type="text/css">
    body {
        font-family: sans-serif;
        background-color: #eeeeee;
      }

      .file-upload {
        background-color: #2d3035;
        width: 600px;
        margin: 0 auto;
        padding: 20px;
      }

      .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
      }

      .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
      }

      .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
      }

      .file-upload-content {
        display: none;
        text-align: center;
      }

      .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
      }

      .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
      }

      .image-dropping,
      .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
      }

      .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
      }

      .drag-text {
        text-align: center;
      }

      .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
      }

      .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
      }

      .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
      }

      .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
      }

      .remove-image:active {
        border: 0;
        transition: all .2s ease;
      }
  </style>
@endpush
