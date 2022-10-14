@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Laporan Bulanan')
<?php $subtitle="Transaksi Toko"; ?>

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Transaksi Toko</h2>
        </div>
    </div>
    <section class="no-padding-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7">
                    <div class="block margin-bottom-sm">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="title"><strong>Produk</strong></div>
                            </div>
                            <div class="col-md-8 float-right">
                                <form class="form-inline" action="{{ url('/transcation') }}" method="get">
                                    <div class="form-group">
                                        <input id="inlineFormInputGroup" type="text" placeholder="Cari Produk" class="mr-sm-2 form-control form-control" name="search" onblur="this.form.submit()">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Cari Sekarang" class="btn btn-utama">
                                    </div>
                                </form>
                            </div>
                        </div><hr>
                        <div class="card" style="background-color: transparent; border: none;">
                            <div class="row ml-4">
                                @foreach ($products as $product)
                                <div style="width: 10rem; background-color: #22252a; border:1px solid rgba(0,0,0,.125)"" class="mb-2 ml-1">
                                    <div class="productCard">
                                        <form action="{{url('/transcation/addproduct', $product->id)}}" method="POST">
                                            @csrf
                                            @if($product->qty == 0)
                                            <img class="card-img-top" src="{{ $product->image }}" alt="..."
                                                style="cursor: pointer; width: 156px; height: 141px;">
                                            @else
                                            <img class="card-img-top" src="{{ $product->image }}" alt="..."
                                                style="cursor: pointer; width: 156px; height: 141px;"
                                                onclick="this.closest('form').submit();return false;">
                                            @endif
                                        </form>
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ Str::words($product->name,4) }} ({{$product->qty}}) </h5>
                                            <p>Rp {{ number_format($product->price,2,',','.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="block margin-bottom-sm">
                        <div class="title pb-3"><strong>Pesanan</strong></div><hr>
                        <div class="table-responsive" style="min-height:53vh">
                            <table class="table table-striped table-sm">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Produk</th>
                                  <th>Qty</th>
                                  <th>Sub Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                $no=1
                                @endphp
                                @forelse($cart_data as $index=>$item)
                                <tr>
                                  <th scope="row">
                                    <form action="{{url('/transcation/removeproduct',$item['rowId'])}}"
                                        method="POST">
                                        @csrf
                                        {{$no++}} <br>
                                        <a onclick="this.closest('form').submit();return false;">
                                            <i class="fa fa-trash sampah" style="color: rgb(134, 134, 134)">
                                        </i></a>
                                    </form>
                                  </th>
                                  <td>
                                    {{Str::words($item['name'],3)}} <br>Rp {{ number_format($item['pricesingle'],2,',','.') }}
                                  </td>
                                  <td>
                                    <form action="{{url('/transcation/decreasecart', $item['rowId'])}}"
                                    method="POST" style='display:inline;'>
                                        @csrf
                                        <button class="btn btn-sm btn-info" style="display: inline;padding:0.4rem 0.6rem!important">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </form>
                                    <a style="display: inline">{{$item['qty']}}</a>
                                    <form action="{{url('/transcation/increasecart', $item['rowId'])}}" method="POST" style='display:inline;'>
                                        @csrf
                                        <button class="btn btn-sm btn-utama" style="display: inline;padding:0.4rem 0.6rem!important">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </form>
                                  </td>
                                  <td class="text-right">Rp {{ number_format($item['price'],2,',','.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Empty Cart</td>
                                </tr>
                                @endforelse
                              </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>Sub Total</h6>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h6>Rp {{ number_format($data_total['sub_total'],2,',','.') }} </h6>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <form action="{{ url('/transcation') }}" method="get">
                                    <h6>PPN 10%
                                        <input id="option" type="checkbox" {{ $data_total['tax'] > 0 ? "checked" : ""}} name="tax"
                                        value="true" onclick="this.form.submit()">
                                    </h6>
                                </form>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h6>Rp {{ number_format($data_total['tax'],2,',','.') }}</h6>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>Total</h6>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h6>Rp {{ number_format($data_total['total'],2,',','.') }}</h6>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-4">
                                <form action="{{ url('/transcation/clear') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-utama btn-block"
                                    onclick="return confirm('Apakah anda yakin ingin meng-clear cart ?');"
                                    type="submit">Bersihkan</button>
                                </form>
                            </div>
                            <div class="col-sm-4">
                                <a class="btn btn-utama btn-block" href="{{url('/transcation/history')}}" target="_blank">Riwayat</a>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-utama btn-block" data-toggle="modal" data-target="#fullHeightModalRight">Bayar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fullHeightModalRight" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-full-height modal-right" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title w-100 text-light" id="myModalLabel">Konfirmasi Pesanan</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="60%">Sub Total</th>
                            <th width="40%" class="text-right">Rp {{ number_format($data_total['sub_total'],2,',','.') }} </th>
                        </tr>
                        @if($data_total['tax'] > 0)
                        <tr>
                            <th>PPN 10%</th>
                            <th class="text-right">Rp {{ number_format($data_total['tax'],2,',','.') }}</th>
                        </tr>
                        @endif
                    </table>
                    <form action="{{ url('/transcation/bayar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="oke">Masukkan Jumlah Bayar</label>
                        <input id="oke" class="form-control" type="number" name="bayar" autofocus />
                    </div>
                    <h3 class="font-weight-bold">Total:</h3>
                    <h1 class="font-weight-bold mb-5">Rp. {{ number_format($data_total['total'],2,',','.') }}</h1>
                    <input id="totalHidden" type="hidden" name="totalHidden" value="{{$data_total['total']}}" />

                    <h3 class="font-weight-bold">Bayar:</h3>
                    <h1 class="font-weight-bold mb-5" id="pembayaran"></h1>

                    <h3 class="font-weight-bold text-primary">Kembalian:</h3>
                    <h1 class="font-weight-bold text-primary" id="kembalian"></h1>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-utama" id="saveButton" disabled onClick="openWindowReload(this)">Save transcation</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </section>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if(Session::has('error'))
<script>
    toastr.error(
        'Telah mencapai jumlah maximum Product | Silahkan tambah stock Product terlebih dahulu untuk menambahkan'
    )

</script>
@endif

@if(Session::has('errorTransaksi'))
<script>
    toastr.error(
        'Transaksi tidak valid | perhatikan jumlah pembayaran | cek jumlah product'
    )

</script>
@endif

@if(Session::has('success'))
<script>
    toastr.success(
        'Transaksi berhasil | Thank Your from Tahu Coding'
    )

</script>
@endif

<script>
    $(document).ready(function () {
        $('#fullHeightModalRight').on('shown.bs.modal', function () {
            $('#oke').trigger('focus');
        });
    });

    oke.oninput = function () {
        let jumlah = parseInt(document.getElementById('totalHidden').value) ? parseInt(document.getElementById('totalHidden').value) : 0;
        let bayar = parseInt(document.getElementById('oke').value) ? parseInt(document.getElementById('oke').value) : 0;
        let hasil = bayar - jumlah;
        document.getElementById("pembayaran").innerHTML = bayar ? 'Rp ' + rupiah(bayar) + ',00' : 'Rp ' + 0 +
            ',00';
        document.getElementById("kembalian").innerHTML = hasil ? 'Rp ' + rupiah(hasil) + ',00' : 'Rp ' + 0 +
            ',00';

        cek(bayar, jumlah);
        const saveButton = document.getElementById("saveButton");

        if(jumlah === 0){
            saveButton.disabled = true;
        }

    };

    function cek(bayar, jumlah) {
        const saveButton = document.getElementById("saveButton");

        if (bayar < jumlah) {
            saveButton.disabled = true;
        } else {
            saveButton.disabled = false;
        }
    }

    function rupiah(bilangan) {
        var number_string = bilangan.toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    }

</script>
@endpush

@push('style')
<style>
    .productCard {
        cursor: pointer;
    }

    .productCard:hover {
        border: solid 1px rgb(172, 172, 172);
    }

    .btn-utama{
        color: white;
        background-color: #DB6574;
        border-color: #DB6574;
    }

    .btn-utama:hover{
    color: white;
    background-color: #d44658;
    border-color: #d13c4f
    }

    .sampah{
        cursor: pointer;
    }
</style>
@endpush
