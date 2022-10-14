<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapanganModel extends Model
{
    use HasFactory;
    protected $table = 'info_lapangan';
    protected $primaryKey = 'id_lapangan';

    public function jenis()
    {
    	//					MODEL TUJUANE			  ID ASAL     ID TUJUANE
        return $this->hasOne('App\Models\JenisModel', 'id_jenis', 'id_jenis');
    }
}
