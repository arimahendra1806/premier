@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Detail Transaksi')
<!-- <?php $subtitle="Detail"; ?> -->

@push('notif')
<span>{{$dataTrxMem}}</span>
@endpush()

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          {{-- <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Detail Transaksi Toko</h2>
          </div> --}}
        </div>
  	    <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <!-- Basic Form-->
              <div class="col-lg-12">
                <div class="block">
                  <div class="block-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>Nota Pembelian</h2>
                        </div>
                        <div class="col-lg-6 text-right">
                            {{-- <a href="{{ URL::previous() }}" class="btn btn-success float-right btn-sm"><i class="fas fa-arrow-left"></i> Back</a> --}}
                            <a class="btn btn-primary text-white btn-sm mb-4" id="printPageButton" onclick="window.print()"><i class="fa-print"></i> Print</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <table width="100%" class="table table-borderless">
                            <tr>
                                <td class="font-weight-bold">Invoices Number</td>
                                <td class="font-weight-bold">:</td>
                                <td class="font-weight-bold">{{$transaksi->invoices_number}}</td>
                                <td>Pay</td>
                                <td>:</td>
                                <td>{{$transaksi->pay}}</td>
                            </tr>
                            <tr>
                                <td>Admin</td>
                                <td>:</td>
                                <td>{{$transaksi->admin->nama_lengkap}}</td>
                                <td>Total</td>
                                <td>:</td>
                                <td>{{$transaksi->total}}</td>
                            </tr>
                            <tr>
                                <td>Create At</td>
                                <td>:</td>
                                <td>{{$transaksi->created_at}}</td>
                                <td>Customer</td>
                                <td>:</td>
                                <td>Take Away Customer</td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-sm" width="100%">
                                <thead>
                                    <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi->productTranscation as $index=>$item)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$item->product->name}}</td>
                                            <td>{{$item->qty}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

@push('style')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
@endpush
