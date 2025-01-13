<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LogAktivitas extends Model
{
    protected $table = 'tbl_log_aktivitas';
    
    protected $fillable = [
        'model',
        'aksi',
        'data',
        'id_user',
        'user_role',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_login'); 
    }
}
