<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\TransaksiModel;
use App\Models\MemberModel;
use App\Models\JenisModel;
use App\Models\LapanganModel;
use App\Models\Transcation;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //menampilkan halaman login
    public function login(){
    	return view('layouts.newlogin');
    }

    //menampilkan halaman register
    public function register(){
    	return view('layouts.newregister');
    }

    //menampilkan halaman dashboard
    public function dashboard(){
        //COUNT MEMBER
        $dataMember = MemberModel::count('id_member');
        //COUNT JUMLAH TRANSAKSI
        $dataTrx = TransaksiModel::count('id_transaksi');
        //COUNT JUMLAH TRANSAKSI SUKSES
        $dataTrxSs = TransaksiModel::all()->where('status_booking', '!=', 'Menunggu')->count('id_transaksi');
        //COUNT JUMLAH TRANSAKSI MENUNGGU
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');
        //COUNT JUMLAH TRANSAKSI MENUNGGU LAPANGAN A
        $dataTrxMem1 = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->where('id_lapangan', '=', 'LP1')->count('id_transaksi');
        //COUNT JUMLAH TRANSAKSI MENUNGGU LAPANGAN B
        $dataTrxMem2 = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->where('id_lapangan', '=', 'LP2')->count('id_transaksi');
        //COUNT TOTAL TRANSAKSI BULAN INI
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        $dataTotal = TransaksiModel::all()->whereBetween('tanggal_booking', [$start, $end])->where('status_booking', '!=', 'Menunggu')->where('jenis_transaksi', '=', 'online')->sum('total_bayar');
        $dataTotalOffline = TransaksiModel::all()->whereBetween('tanggal_booking', [$start, $end])->where('status_booking', '!=', 'Menunggu')->where('jenis_transaksi', '=', 'offline')->sum('total_bayar');
        $dataTotalToko = Transcation::all()->whereBetween('created_at', [$start, $end])->sum('total');
        //TAMPILKAN HARGA SINTETIS
        $hargaA = JenisModel::all()->where('jenis_lapangan', '=', 'Sintetis');
        //TAMPILKAN HARGA VINYL
        $hargaB = JenisModel::all()->where('jenis_lapangan', '=', 'Vinyl');
        //TAMPILAN FOTO LAPANGAN U/ MEMBER
        $lap1 = LapanganModel::all()->where('id_jenis', '=', '1');
        $lap2 = LapanganModel::all()->where('id_jenis', '=', '2');
    	return view('dashboard', ['dataTrx' => $dataTrx, 'dataMem' => $dataMember, 'dataTrxSs' => $dataTrxSs, 'dataTrxMem' => $dataTrxMem, 'dataTrxMem1' => $dataTrxMem1, 'dataTrxMem2' => $dataTrxMem2, 'dataTotal' => $dataTotal, 'dataTotal2' => $dataTotalOffline, 'dataTotal3' => $dataTotalToko, 'hargaA' => $hargaA, 'hargaB' => $hargaB, 'lap1' => $lap1, 'lap2' => $lap2]);
    }

    //menampilkan halaman postlogin
    public function postlogin(Request $request){
    	//kondisi login
    	if (Auth::attempt($request->only('email', 'password'))){
    		//jika login sukses
    		return redirect('/dashboard');
    	}
    	else{
    		return back()->withErrors(['email' => ['Wrong credentials please try again']]);
    	}
    }

    //proses logout
    public function logout(){
    	Auth::logout();
    	//redirect halaman
    	return redirect('/');
    }

    //menampilkan halaman reject
    public function reject(){
    	return view('layouts.reject');
    }

    //menampilkan halaman rejetrole
    public function rejectrole(){
    	return view('layouts.rejectrole');
    }

}
