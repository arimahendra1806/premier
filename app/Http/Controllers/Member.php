<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TransaksiModel;
use App\Models\MemberModel;
use App\Models\LapanganModel;
use App\Models\JenisModel;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use PDF;
use Auth;
use File;
use Intervention\Image\Facades\Image;

class Member extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexProfile()
    {
        //User
        $id = Auth::user()->id_user;
        $member = MemberModel::where('id_user', '=', $id)->value('id_member');
        $dataTrx = TransaksiModel::all()->where('id_member', '=', $member)->count('id_transaksi');

        //Member
        $editMember = MemberModel::all()->where('id_user', '=', $id);

        //Riwayat
        $dataRw = TransaksiModel::sortable()->where('id_member', '=', $member)->orderByDesc('tanggal_booking')->paginate(5);
        //return
        return view('member.indexProfile', ['dataTrx' => $dataTrx, 'data' => $editMember, 'dataRw' => $dataRw]);
    }

    public function indexDaftar()
    {
        //Daftar Booking
        $from = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
        $data = TransaksiModel::sortable()->whereBetween('tanggal_booking', [$from, '3099-12-31'])->orderByDesc('tanggal_booking')->paginate(10);
        return view('member.indexDaftar', ['data' => $data]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexKontak()
    {
        return view('member.indexKontak');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexExtra($id)
    {
        $data = TransaksiModel::all()->where('id_transaksi', '=', $id);
        return view('member.indexExtra', ['data' => $data]);
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
    public function createTrx()
    {
        //
        $id = Auth::user()->id_user;
        $data = MemberModel::all()->where('id_user', '=', $id)->count('id_member');
        $idMember = MemberModel::all()->where('id_user', '=', $id);
        $hrg1 = JenisModel::all()->where('id_jenis', '=', '1');
        $hrg2 = JenisModel::all()->where('id_jenis', '=', '2');
        return view('member.createTrx', ['data' => $data, 'idMember' => $idMember, 'hrg1' => $hrg1, 'hrg2' => $hrg2]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTrx(Request $request)
    {

        if (TransaksiModel::where('tanggal_booking', $request->tanggal_booking)->where('id_lapangan', $request->id_lapangan)->exists()) {
           if (TransaksiModel::where('tanggal_booking', $request->tanggal_booking)->where('id_lapangan', $request->id_lapangan)->where('jam_masuk', $request->jam_masuk)->exists()) {
                return redirect()->back()->with('error','Lapangan dan Waktu Sudah Dipesan');
           } else {
                //bisa.order();
                $from = Carbon::now()->subDays(1)->format('Y-m-d');
                $rules = [
                    'id_transaksi'      => 'required|unique:transaksi',
                    'id_lapangan'       => 'required',
                    'tanggal_booking'   => 'required|after:$from',
                    'jam_masuk'         => 'required',
                    'jam_keluar'        => 'required|after:jam_masuk',
                    'total_jam'         => 'required',
                    'harga_booking'     => 'required',
                    'total_booking'     => 'required',
                    'pembayaran'        => 'required'
                ];

                $messages = [
                    'id_transaksi.required'      => 'Id Transaksi Wajib diisi',
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
                    'pembayaran.required'        => 'Pembayaran Wajib diisi'
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
                'id_lapangan'       => 'required',
                'tanggal_booking'   => 'required|after:$from',
                'jam_masuk'         => 'required',
                'jam_keluar'        => 'required|after:jam_masuk',
                'total_jam'         => 'required',
                'harga_booking'     => 'required',
                'total_booking'     => 'required',
                'pembayaran'        => 'required'
            ];

            $messages = [
                'id_transaksi.required'      => 'Id Transaksi Wajib diisi',
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
                'pembayaran.required'        => 'Pembayaran Wajib diisi'
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
        $data->jenis_transaksi = "online";
        $data->save();

        return redirect('/member/profile')->with('success','Success Melakukan Booking Lapangan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request)
    {
        $post = new MemberModel;
        $post->id_member = $request->id_member;
        $post->nama_lengkap = $request->nama_lengkap;
        $post->id_user = $request->id_user;
        $post->no_hp = $request->no_hp;
        $post->alamat = $request->alamat;
        $post->save();

        return redirect('/member/createBooking')->with('success','Success Memperbaharui Detail Profile Anda');
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
    public function editBukti($id)
    {
        //
        $data = TransaksiModel::where('id_transaksi', $id)->get();
        return view('member.editBukti', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile($id)
    {
        //
        $data = MemberModel::where('id_member', $id)->get();
        return view('member.editProfile', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
    public function updateBukti(Request $request, $id)
    {
        $data_id = TransaksiModel::find($id);
        $gambar = $request->bukti_bayar;
        $new_gambar = time().$gambar->getClientOriginalName();
        Image::make($gambar->getRealPath())->resize(null, 800, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/images/' . $new_gambar));

        File::delete(public_path($data_id->bukti_bayar));

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
        $data->bukti_bayar = 'uploads/images/' . $new_gambar;
        $data->save();
        return redirect('/member/profile')->with('success','Success Update Bukti Pembayaran');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        //
        $id_user = MemberModel::where('id_member', $id)->value('id_user');
        $post = MemberModel::where('id_member', $id)->first();
        $pass = User::where('id_user', $id_user)->first();

        if($request->password == null){
            $post->nama_lengkap = $request->nama_lengkap;
            $post->id_user = $request->id_user;
            $post->no_hp = $request->no_hp;
            $post->alamat = $request->alamat;
            $post->save();
        } else {
            $post->nama_lengkap = $request->nama_lengkap;
            $post->id_user = $request->id_user;
            $post->no_hp = $request->no_hp;
            $post->alamat = $request->alamat;
            $post->save();

            $pass->password = Hash::make($request->password);
            $pass->save();
        }

        return redirect('/member/profile')->with('success','Success Update Profile');
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

    public function searchDaftar(Request $request)
    {
        //Cari Daftar Booking
        $cari = $request->cari;
        $data = TransaksiModel::where('tanggal_booking', 'like', "%".$cari."%")->paginate();
        session()->flashInput($request->input());
        return view('member.indexDaftar', ['data' => $data]);
    }

    public function notaPdf($id)
    {
        // $id = Auth::user()->id_user;
        // $member = MemberModel::all()->where('id_user', '=', $id)->value('id_member');
        //KEMUDIAN BUAT QUERY
        $data = TransaksiModel::all()->where('id_transaksi', '=', $id);
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('member.notaPdf', ['ndata' => $data])->setPaper('A4', 'potrait');
        //GENERATE PDF-NYA
        return $pdf->stream();
    }
}
