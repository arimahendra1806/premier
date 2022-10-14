@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Kelola Produk')
<?php $subtitle="Produk Toko"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Kelola Produk</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            @include('flash-message')
            <div class="row">
              <div class="col-lg-12">
                <div class="block margin-bottom-sm">
                  <div class="title"><strong>Produk Toko Premier Futsal Kediri</strong></div>
                    <form action="{{ url('/product') }}" method="get">
                        <div class="row">
                            <div class="col">
                                <a href="{{ url('product/create') }}" class="btn btn-utama float-right btn-sm">Tambah Produk</a>
                                <input type="text" name="search" class="form-control form-control-sm col-sm-3 float-right mr-4"
                                placeholder="Cari Produk..." onblur="this.form.submit()">
                            </div>
                        </div>
                    </form><br>
                  <div class="table-responsive">
                    <table class="table" id="myTable" width="100%">
                      <thead>
                        <tr>
                          <th>@sortablelink('loop','#')</th>
                          <th>@sortablelink('name','Nama Barang')</th>
                          <th>@sortablelink('price','Harga')</th>
                          <th>@sortablelink('qty','Qty')</th>
                          <th>@sortablelink('','Gambar')</th>
                          <th>@sortablelink('','Aksi')</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
	                        @forelse($products as $product)
	                            <tr>
	                                <td>{{$loop->iteration + $products->firstItem()-1}}</td>
	                                <td><p>{{ Str::words($product->name,6) }}</p></td>
	                                <td>Rp. {{ number_format($product->price,2,',','.') }}</td>
                                    <td>{{ $product->qty }}</td>
	                                <td><img class="gambar" src="{{ $product->image }}" width="80px" height="90px"></td>
                                    <td>
                                        <a href="{{ url('product/update', $product->id) }}" class="btn btn-info btn-md">Detail</a>
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
                    <!-- {!! $products->appends(Request::except('page'))->render() !!} -->
      				{!! $products->links('vendor.pagination.bootstrap-4') !!}
                  </div>
                </div>
              </div>
             </div>
           </div>
      </section>
@endsection
