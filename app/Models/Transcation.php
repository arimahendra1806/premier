<?php
//© 2020 Copyright: Tahu Coding
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transcation extends Model
{
    //demi keamanan kalian harusnya ubah ini ke fillable ya
    protected $guarded = [];

    protected $primaryKey = 'invoices_number';
    public $incrementing = false;
    protected $keyType = 'string';

    public function productTranscation(){
        return $this->hasMany(ProductTranscation::class,'invoices_number','invoices_number');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->hasOne(AdminModel::class,'id_user','user_id');
    }

}
