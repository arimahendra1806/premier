<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\HistoryProduct;
use App\Models\ProductTranscation;
use App\Models\TransaksiModel;
use App\Models\Transcation;
use Auth;
use DB;
use Carbon\Carbon;
use PDF;

use Darryldecode\Cart\CartCondition;

use Haruncpi\LaravelIdGenerator\IdGenerator;


class TransactionController extends Controller
{
    public function index(){
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');

        //product
        $products = Product::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->orderBy('created_at','desc')
                    ->paginate(12);

        //cart item
        if(request()->tax){
            $tax = "+10%";
        }else{
            $tax = "0%";
        }

        $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'pajak',
                'type' => 'tax', //tipenya apa
                'target' => 'total', //target kondisi ini apply ke mana (total, subtotal)
                'value' => $tax, //contoh -12% or -10 or +10 etc
                'order' => 1
            ));

        \Cart::session(Auth()->id())->condition($condition);

        $items = \Cart::session(Auth()->id())->getContent();

        if(\Cart::isEmpty()){
            $cart_data = [];
        }
        else{
            foreach($items as $row) {
                $cart[] = [
                    'rowId' => $row->id,
                    'name' => $row->name,
                    'qty' => $row->quantity,
                    'pricesingle' => $row->price,
                    'price' => $row->getPriceSum(),
                    'created_at' => $row->attributes['created_at'],
                ];
            }

            $cart_data = collect($cart)->sortBy('created_at');

        }

        //total
        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();

        $new_condition = \Cart::session(Auth()->id())->getCondition('pajak');
        $pajak = $new_condition->getCalculatedValue($sub_total);

        $data_total = [
            'sub_total' => $sub_total,
            'total' => $total,
            'tax' => $pajak
        ];
        return view('pos.index', compact('products','cart_data','data_total','dataTrxMem'));
    }

    public function addProductCart($id){
        $product = Product::find($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $cek_itemId = $cart->whereIn('id', $id);

        if($cek_itemId->isNotEmpty()){
            if($product->qty == $cek_itemId[$id]->quantity){
                return redirect()->back()->with('error','jumlah item kurang');
            }else{
                \Cart::session(Auth()->id())->update($id, array(
                    'quantity' => 1
                ));
            }
        }else{
             \Cart::session(Auth()->id())->add(array(
            'id' => $id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(
                'created_at' => date('Y-m-d H:i:s')
            )
        ));

        }

        return redirect()->back();
    }

    public function removeProductCart($id){
        \Cart::session(Auth()->id())->remove($id);

        return redirect()->back();
    }

    public function bayar(){

        $cart_total = \Cart::session(Auth()->id())->getTotal();
        $bayar = request()->bayar;
        $kembalian = (int)$bayar - (int)$cart_total;

        if($kembalian >= 0){
            DB::beginTransaction();

            try{

            $all_cart = \Cart::session(Auth()->id())->getContent();


            $filterCart = $all_cart->map(function($item){
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity
                ];
            });

            foreach($filterCart as $cart){
                $product = Product::find($cart['id']);

                if($product->qty == 0){
                    return redirect()->back()->with('errorTransaksi','jumlah pembayaran gak valid');
                }

                HistoryProduct::create([
                    'product_id' => $cart['id'],
                    'user_id' => Auth::id(),
                    'qty' => $product->qty,
                    'qtyChange' => -$cart['quantity'],
                    'tipe' => 'decrease from transaction'
                ]);

                $product->decrement('qty',$cart['quantity']);
            }

            $id = IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' =>'INV-', 'field' => 'invoices_number']);

            Transcation::create([
                'invoices_number' => $id,
                'user_id' => Auth::id(),
                'pay' => request()->bayar,
                'total' => $cart_total
            ]);

            foreach($filterCart as $cart){

                ProductTranscation::create([
                    'product_id' => $cart['id'],
                    'invoices_number' => $id,
                    'qty' => $cart['quantity'],
                ]);
            }

            \Cart::session(Auth()->id())->clear();

            DB::commit();
            return redirect()->back()->with('success','Transaksi Berhasil dilakukan Tahu Coding | Klik History untuk print');
            }catch(\Exeception $e){
            DB::rollback();
                return redirect()->back()->with('errorTransaksi','jumlah pembayaran gak valid');
            }
        }
        return redirect()->back()->with('errorTransaksi','jumlah pembayaran gak valid');

    }

    public function clear(){
        \Cart::session(Auth()->id())->clear();
        return redirect()->back();
    }

    public function decreasecart($id){
        $product = Product::find($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $cek_itemId = $cart->whereIn('id', $id);

        if($cek_itemId[$id]->quantity == 1){
            \Cart::session(Auth()->id())->remove($id);
        }else{
            \Cart::session(Auth()->id())->update($id, array(
            'quantity' => array(
                'relative' => true,
                'value' => -1
            )));
        }
        return redirect()->back();

    }


    public function increasecart($id){
        $product = Product::find($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $cek_itemId = $cart->whereIn('id', $id);

        if($product->qty == $cek_itemId[$id]->quantity){
            return redirect()->back()->with('error','jumlah item kurang');
        }else{
            \Cart::session(Auth()->id())->update($id, array(
            'quantity' => array(
                'relative' => true,
                'value' => 1
            )));

            return redirect()->back();
        }
    }

    public function history(){
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');

        $history = Transcation::orderBy('created_at','desc')->paginate(10);
        return view('pos.history',compact('history','dataTrxMem'));
    }

    public function laporan($id){
        //notif
        $dataTrxMem = TransaksiModel::all()->where('status_booking', '=', 'Menunggu')->count('id_transaksi');

        $transaksi = Transcation::with('productTranscation')->find($id);
        return view('pos.showHistory',compact('transaksi','dataTrxMem'));
    }

    public function laporanPdf($daterange)
    {
        //
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $data = Transcation::all()->whereBetween('created_at', [$start, $end]);
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('pos.laporan', ['ndata' => $data, 'ndate' => $date])->setPaper('A4', 'landscape');
        //GENERATE PDF-NYA
        return $pdf->stream();
    }

}
