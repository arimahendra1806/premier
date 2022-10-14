<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <h4 style="text-align: center;"><strong>Laporan Transaksi Toko<br>Premier Futsal Kediri</strong></h4>
    <h6>Periode : {{date('d-m-Y', strtotime($ndate[0]))}} sampai {{date('d-m-Y', strtotime($ndate[1]))}}</h6>
    <hr style="height:5px;border-width:0;color:black;background-color:black">
    <table width="100%" class="table-hover table-bordered">
        <thead style="text-align: center;">
            <tr>
                <th><strong>#</strong></th>
                <th><strong>Invoices</strong></th>
                <th><strong>Admin</strong></th>
                <th><strong>Total</strong></th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @php $sum=0 @endphp
            @foreach($ndata as $data)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$data->invoices_number}}</td>
                    <td style="text-transform: capitalize;">{{$data->admin->nama_lengkap}}</td>
                    <td>Rp. {{$data->total}},-</td>
                </tr>
                @php
                    $sum += $data->total;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: center;">Grand Total {{date('F', strtotime($ndate[0]))}} {{date('Y', strtotime($ndate[0]))}}</td>
                <td>Rp. {{$sum}},-</td>
            </tr>
        </tfoot>
    </table>
    <style>
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
        /*.fit {
            width:1%;
            white-space:nowrap;
        }*/
    </style>
</body>
</html>
