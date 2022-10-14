<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiModel;
use App\Models\MemberModel;
use App\Models\AdminModel;
use App\Models\LapanganModel;
use App\Models\JenisModel;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Validator;
use Auth;
// use App\Models\LapanganModel;
// use App\Models\MemberModel;

class Transaksi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*INFORMASI LAPANGAN*/
    public function index()
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //Iformasi Booking
        $from = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
        $data = TransaksiModel::sortable()->whereBetween('tanggal_booking', [$from, '3099-12-31'])->orderByDesc('tanggal_booking')->paginate(10);
        return view('admin.index', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);

    }
    /*KONFIRMASI PEMBAYARAN*/
    public function indexKonfirmasi()
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $data = TransaksiModel::sortable()->where('status_booking', '=', 'Menunggu')->orderByDesc('tanggal_booking')->paginate(10);
        return view('admin.indexKonfirmasi', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);

    }
    /*LAPORAN BULANAN ONLINE*/
    public function indexLaporan()
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        //DAN ENDOFMONTH UNTUK MENGAMBIL TANGGAL TERAKHIR DIBULAN YANG BERLAKU SAAT INI
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        //JIKA USER MELAKUKAN FILTER MANUAL, MAKA PARAMETER DATE AKAN TERISI
        if (request()->date != '') {
            //MAKA FORMATTING TANGGALNYA BERDASARKAN FILTER USER
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $data = TransaksiModel::sortable()->whereBetween('tanggal_booking', [$start, $end])->where('status_booking', '!=', 'Menunggu')->where('jenis_transaksi', '=', 'online')->orderByDesc('tanggal_booking')->paginate(10);
        return view('admin.indexLaporan', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }

    /*LAPORAN BULANAN OFFLINE*/
    public function indexLaporanOffline()
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        //DAN ENDOFMONTH UNTUK MENGAMBIL TANGGAL TERAKHIR DIBULAN YANG BERLAKU SAAT INI
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        //JIKA USER MELAKUKAN FILTER MANUAL, MAKA PARAMETER DATE AKAN TERISI
        if (request()->date != '') {
            //MAKA FORMATTING TANGGALNYA BERDASARKAN FILTER USER
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $data = TransaksiModel::sortable()->whereBetween('tanggal_booking', [$start, $end])->where('status_booking', '!=', 'Menunggu')->where('jenis_transaksi', '=', 'offline')->orderByDesc('tanggal_booking')->paginate(10);
        return view('admin.indexLaporanOffline', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookingOffline()
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');

        $id = Auth::user()->id_user;
        $idadmin = AdminModel::all()->where('id_user', '=', $id);
        $idMember = 'MB0000';
        $hrg1 = JenisModel::all()->where('id_jenis', '=', '1');
        $hrg2 = JenisModel::all()->where('id_jenis', '=', '2');
        return view('admin.bookingOffline', ['dataTrxMem' => $dataTrxMem, 'idadmin' => $idadmin, 'idMember' => $idMember, 'hrg1' => $hrg1, 'hrg2' => $hrg2]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBookingOffline(Request $request)
    {
        if (TransaksiModel::where('tanggal_booking', $request->tanggal_booking)->where('id_lapangan', $request->id_lapangan)->exists()) {
            if (TransaksiModel::where('tanggal_booking', $request->tanggal_booking)->where('id_lapangan', $request->id_lapangan)->where('jam_masuk', $request->jam_masuk)->exists()) {
                 return redirect()->back()->with('error','Lapangan dan Waktu Sudah Dipesan');
            } else {
                 //bisa.order();
                 $from = Carbon::now()->subDays(1)->format('Y-m-d');
                 $rules = [
                     'id_transaksi'      => 'required|unique:transaksi',
                     'member_offline'    => 'required',
                     'id_lapangan'       => 'required',
                     'tanggal_booking'   => 'required|after:$from',
                     'jam_masuk'         => 'required',
                     'jam_keluar'        => 'required|after:jam_masuk',
                     'total_jam'         => 'required',
                     'harga_booking'     => 'required',
                     'total_booking'     => 'required',
                     'status_booking'    => 'required',
                     'total_bayar'       => 'required',
                     'sisa_bayar'        => 'required'
                 ];

                 $messages = [
                     'id_transaksi.required'      => 'Id Transaksi Wajib diisi',
                     'member_offline.required'    => 'Nama Pemesan Wajib diisi',
                     'id_transaksi.unique'        => 'Id Transaksi Sudah Terdaftar',
                     'id_lapangan.required'       => 'Id Lapangan Wajib diisi',
                     'tanggal_booking.required'   => 'Tanggal Booking Wajib diisi',
                     'tanggal_booking.after'      => 'Tidak Bisa Memilih Tanggal Sebelum Hari Ini',
                     'jam_masuk.required'         => 'Jam Masuk Wajib diisi',
                     'jam_keluar.required'        => 'Jam Keluar Wajib diisi',
                     'jam_keluar.after'           => 'Waktu Anda Tidak Valid',
                     'total_jam.required'         => 'Total Jam Wajib diisi',
                     'harga_booking.required'     => 'Harga Booking Wajib diisi',
                     'total_booking.required'     => 'Total Booking Wajib diisi',
                     'status_booking.required'    => 'Pembayaran Wajib diisi',
                     'total_bayar.required'       => 'Pembayaran Wajib diisi',
                     'sisa_bayar.required'        => 'Pembayaran Wajib diisi'
                 ];

                 $validator = Validator::make($request->all(), $rules, $messages);
                 if ($validator->fails()){
                     return redirect()->back()->withErrors($validator)->withInput($request->all());
                 }
            }
         } else {
             //bisa.order();
             $from = Carbon::now()->subDays(1)->format('Y-m-d');
             $rules = [
                'id_transaksi'      => 'required|unique:transaksi',
                'member_offline'    => 'required',
                'id_lapangan'       => 'required',
                'tanggal_booking'   => 'required|after:$from',
                'jam_masuk'         => 'required',
                'jam_keluar'        => 'required|after:jam_masuk',
                'total_jam'         => 'required',
                'harga_booking'     => 'required',
                'total_booking'     => 'required',
                'status_booking'    => 'required',
                'total_bayar'       => 'required',
                'sisa_bayar'        => 'required'
             ];

             $messages = [
                'id_transaksi.required'      => 'Id Transaksi Wajib diisi',
                'member_offline.required'    => 'Nama Pemesan Wajib diisi',
                'id_transaksi.unique'        => 'Id Transaksi Sudah Terdaftar',
                'id_lapangan.required'       => 'Id Lapangan Wajib diisi',
                'tanggal_booking.required'   => 'Tanggal Booking Wajib diisi',
                'tanggal_booking.after'      => 'Tidak Bisa Memilih Tanggal Sebelum Hari Ini',
                'jam_masuk.required'         => 'Jam Masuk Wajib diisi',
                'jam_keluar.required'        => 'Jam Keluar Wajib diisi',
                'jam_keluar.after'           => 'Waktu Anda Tidak Valid',
                'total_jam.required'         => 'Total Jam Wajib diisi',
                'harga_booking.required'     => 'Harga Booking Wajib diisi',
                'total_booking.required'     => 'Total Booking Wajib diisi',
                'status_booking.required'    => 'Pembayaran Wajib diisi',
                'total_bayar.required'       => 'Pembayaran Wajib diisi',
                'sisa_bayar.required'        => 'Pembayaran Wajib diisi'
             ];

             $validator = Validator::make($request->all(), $rules, $messages);
             if ($validator->fails()){
                 return redirect()->back()->withErrors($validator)->withInput($request->all());
             }
         }

         $data = new TransaksiModel;
         //sebelah kiri nama di DB dan sebelah kanan nama diform (view)
         $data->id_transaksi = $request->id_transaksi;
         $data->id_member = $request->id_member;
         $data->id_admin = $request->id_admin;
         $data->id_lapangan = $request->id_lapangan;
         $data->tanggal_booking = $request->tanggal_booking;
         $data->jam_masuk = $request->jam_masuk;
         $data->jam_keluar = $request->jam_keluar;
         $data->total_jam = $request->total_jam;
         $data->harga_booking = $request->harga_booking;
         $data->total_booking = $request->total_booking;
         $data->total_bayar = $request->total_bayar;
         $data->sisa_bayar = $request->sisa_bayar;
         $data->pembayaran = $request->pembayaran;
         $data->status_booking = $request->status_booking;
         $data->bukti_bayar = $request->bukti_bayar;
         $data->jenis_transaksi = $request->jenis_transaksi;
         $data->member_offline = $request->member_offline;
         $data->save();

         return redirect('/admin/bookingOffline')->with('success','Success Melakukan Booking Lapangan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showLaporan($id)
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $data = TransaksiModel::where('id_transaksi', $id)->get();
        return view('admin.showLaporan', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }

    public function showLaporanOffline($id)
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $data = TransaksiModel::where('id_transaksi', $id)->get();
        return view('admin.showLaporanOffline', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*TAMPILAN EDIT KONFIRMASI PEMBAYARAN*/
    public function editKonfirmasi($id)
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $data = TransaksiModel::where('id_transaksi', $id)->get();
        return view('admin.editKonfirmasi', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*UPDATE PEMBAYARAN*/
    public function updateKonfirmasi(Request $request, $id)
    {
        //
        $data = TransaksiModel::where('id_transaksi', $id)->first();
        //sebelah kiri nama di DB dan sebelah kanan nama diform (view)
        $data->id_member = $request->id_member;
        $data->id_admin = $request->id_admin;
        $data->id_lapangan = $request->id_lapangan;
        $data->tanggal_booking = $request->tanggal_booking;
        $data->jam_masuk = $request->jam_masuk;
        $data->jam_keluar = $request->jam_keluar;
        $data->total_jam = $request->total_jam;
        $data->harga_booking = $request->harga_booking;
        $data->total_booking = $request->total_booking;
        $data->total_bayar = $request->total_bayar;
        $data->sisa_bayar = $request->sisa_bayar;
        $data->pembayaran = $request->pembayaran;
        $data->status_booking = $request->status_booking;
        $data->save();
        return redirect('/admin/konfirmasi')->with('success','Success Update konfirmasi Pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*PENCARIAN INFORMASI BOOKING*/
    public function search(Request $request)
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $cari = $request->cari;
        $data = TransaksiModel::where('tanggal_booking', 'like', "%".$cari."%")->paginate();
        session()->flashInput($request->input());
        return view('admin.index', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }
    /*PENCARIAN KONFIRMASI PEMBAYARAN*/
    public function searchKonfirmasi(Request $request)
    {
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //
        $cariId = $request->cariId;
        $data = TransaksiModel::where('id_transaksi', 'like', "%".$cariId."%")->paginate();
        session()->flashInput($request->input());
        return view('admin.indexKonfirmasi', ['data' => $data, 'dataTrxMem' => $dataTrxMem]);
    }
    /*PENCARIAN LAPORAN BULANAN*/
    public function laporanReportPdf($daterange)
    {
        //
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $data = TransaksiModel::all()->whereBetween('tanggal_booking', [$start, $end])->where('status_booking', '!=', 'Menunggu')->where('jenis_transaksi', '=', 'online');
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('admin.laporanPdf', ['ndata' => $data, 'ndate' => $date])->setPaper('A4', 'landscape');
        //GENERATE PDF-NYA
        return $pdf->stream();
    }

    public function laporanOfflineReportPdf($daterange)
    {
        //
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $data = TransaksiModel::all()->whereBetween('tanggal_booking', [$start, $end])->where('status_booking', '!=', 'Menunggu')->where('jenis_transaksi', '=', 'offline');
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('admin.laporanOfflinePdf', ['ndata' => $data, 'ndate' => $date])->setPaper('A4', 'landscape');
        //GENERATE PDF-NYA
        return $pdf->stream();
    }
}
