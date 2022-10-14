<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    use HasFactory;
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    public $incrementing = false;
    protected $keyType = 'string';

    public function login()
    {
        return $this->hasOne('App\Models\User', 'id_user', 'id_user');
    }
}
