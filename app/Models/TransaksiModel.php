<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class TransaksiModel extends Model
{
 
    use HasFactory;
    use Sortable;
    //table
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    public $sortable = ['id_transaksi','id_member', 'id_admin', 'id_lapangan', 'tanggal_booking', 'jam_masuk', 'jam_keluar', 'total_jam', 'harga_booking', 'total_booking', 'total_bayar', 'sisa_bayar', 'pembayaran', 'status_booking', 'bukti_bayar', 'jenis_transaksi', 'member_offline'];

    public function lapangan()
    {
        return $this->hasOne('App\Models\LapanganModel', 'id_lapangan', 'id_lapangan');
    }

    public function member()
    {
        //memberitahu bahwa mahasiswa punya banyak nilai
        return $this->hasOne('App\Models\MemberModel', 'id_member', 'id_member');
    }

    public function admin()
    {
        //memberitahu bahwa mahasiswa punya banyak nilai
        return $this->hasOne('App\Models\AdminModel', 'id_admin', 'id_admin');
    }
    
}
