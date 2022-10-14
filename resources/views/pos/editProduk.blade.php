@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Konfirmasi Pembayaran')
<?php $subtitle="Tambah Produk"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Tambah Produk</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            @include('flash-message')
            <div class="row">
              <div class="col-lg-12">
                <div class="block margin-bottom-sm">
                  <div class="title"><strong>Tambah Produk Toko Futsal Kediri</strong></div>
                    <form action="{{ url('/product/delete', $product->id ) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning btn-sm float-right"
                            onclick="return confirm('Apakah anda yakin menghapus data ini ?');">Delete Product</button>
                    </form><br>
                    <form action="{{url('/product/store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="qty" value="{{ $product->qty }}">
                        <div class="form-group">
                            <label for="product">Product Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $product->name) }}">
                            @include('layouts.error', ['name' => 'name'])
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" name="price"
                                        value="{{ old('price' , $product->price) }}">
                                    @include('layouts.error', ['name' => 'price'])
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="number" class="form-control" value="{{ old('qty', $product->qty) }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="addQty">Add / Reduce Qty </label>
                                    <input type="number" class="form-control" name="addQty" value="{{ old('addQty') }}"
                                        placeholder="Use positive number to increase | negative number to decrease">
                                    @if(Session::has('errorQty'))
                                    <small class="text-danger font-weight-bold">
                                        {{ Session('errorQty') }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <div class="file-upload">
                                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                                        <div class="image-upload-wrap">
                                            <input class="file-upload-input" type='file' id="image" name="image" onchange="readURL(this);" accept="image/*" />
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
                                    @include('layouts.error', ['name' => 'image'])
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                @if($product->image)
                                <img src="{{asset($product->image)}}" class="img-fluid ml-4 mt-4" id="preview">
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" cols="30" rows="3"
                                class="form-control">{{ old('description', $product->description) }}</textarea>
                            @include('layouts.error', ['name' => 'description'])
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-info btn-md">Ubah Produk</button>
                        </div>
                    </form><br><br>
                </div>
              </div>
             </div>
           </div>
           <div class="container-fluid">
           <div class="row">
            <div class="col-lg-12">
              <div class="block margin-bottom-sm">
                <div class="title"><strong>Product History</strong></div>
                    <table class="table" id="dtMaterialDesignExample">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Updated By</th>
                                <th>Qty Before</th>
                                <th>Qty Added/Reduce</th>
                                <th>Qty</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $index=>$item)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$item->admin->nama_lengkap}}</td>
                                <td>{{$item->qty}}</td>
                                <td>{{$item->qtyChange}}</td>
                                <td>{{$item->qty + $item->qtyChange}}</td>
                                <td>{{$item->created_at->diffForHumans()}}</td>
                                <td>{{$item->tipe}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
