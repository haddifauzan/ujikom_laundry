<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $table = 'tbl_review';

    protected $primaryKey = 'id_review';

    protected $fillable = [
        'name',
        'email',
        'rating',
        'message',
        'is_displayed'
    ];
}
