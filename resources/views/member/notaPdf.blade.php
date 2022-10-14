<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Nota PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
</head>
<style type="text/css">
    .col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:18%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:39%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:57%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:24%; float:left;}
    .col-print-12{width:15%; float:left;}
    table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: rgb(19, 110, 170);
            color: white;
        }
        tfoot {
            background-color: rgb(77, 81, 88);
            color: #FFFFFF;
        }
        tr:hover {background-color: #f5f5f5;}
</style>
<body>
    <!-- <h2 style="text-align: center; padding-bottom: none;"><strong>PREMIER FUTSAL</strong></h2> -->
    <div class="container-fluid">
        <span style="text-align: center;">
            <h1><strong style="font-weight: bold;">PREMIER FUTSAL</strong></h1>
            <!-- <p>Jalan .. Kediri<br>
            Telp : 081222333444</p> -->
        </span>
        <hr style="height:5px;border-width:0;color:black;background-color:black">
        @foreach($ndata as $data)
        <div class="container-fluid">
            <div class="form-group">
                <div class="row">
                    <div class="col-print-12">
                        No Transaksi<br>
                        Tanggal<br>
                        Pemesan<br>
                        Jam Masuk<br>
                        Jam Keluar
                    </div>
                </div>
                <div class="row">
                    <div class="col-print-3">
                        : {{$data->id_transaksi}}<br>
                        : {{date('d M Y', strtotime($data->tanggal_booking))}}<br>
                        : {{$data->member->nama_lengkap}}<br>
                        : {{date('H:i', strtotime($data->jam_masuk))}}<br>
                        : {{date('H:i', strtotime($data->jam_keluar))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-print-5">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-print-1">
                        Status<br>
                        Kasir
                    </div>
                </div>
                <div class="row">
                    <div class="col-print-2">
                        : {{$data->status_booking}}<br>
                        : {{$data->admin->nama_lengkap}}
                    </div>
                </div>
            </div>
        </div>
        <span>
            <br><br><br><br><br>
            <hr style="height:5px;border-width:0;color:black;background-color:black;">
        </span>
        <table width="100%" class="table-hover table-bordered">
            <thead style="text-align: center;">
                <tr>
                    <th><strong>#</strong></th>
                    <th><strong>Lapangan</strong></th>
                    <th><strong>Harga Sewa</strong></th>
                    <th><strong>Jumlah</strong></th>
                    <th><strong>Sub Total</strong></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                            Lapangan {{$data->lapangan->jenis->jenis_lapangan}}
                        </td>
                        <td>
                            Rp. {{$data->harga_booking}}
                        </td>
                        <td>
                            {{$data->total_jam}} Jam
                        </td>
                        <td>Rp. {{$data->total_booking}},-</td><!-- 
                        <td>Rp. {{$data->total_bayar}},-</td>
                        <td>Rp. {{$data->sisa_bayar}},-</td> -->
                    </tr>
            </tbody>
        </table>
        <div class="container-fluid">
            <div class="form-group">
                <div class="row">
                    <div class="col-print-6">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-print-3">
                        Total Pembayaran<br>
                        Jumlah Bayar<br>
                        Sisa Bayar
                    </div>
                </div>
                <div class="row">
                    <div class="col-print-2">
                        : Rp. {{$data->total_booking}},-<br>
                        : Rp. {{$data->total_bayar}},-<br>
                        : Rp. {{$data->sisa_bayar}},-
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br>
        <div class="container-fluid">
            <div class="form-group">
                <div class="row">
                    <div class="col-print-5">
                        <p style="font-size: 10px;">*Bukti Transaksi<br>
                        *Tunjukan ke kasir untuk Pelunasan<br>
                        *Terimakasih telah memesan lapangan futsal kami
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>