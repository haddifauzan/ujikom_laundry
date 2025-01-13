<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class HomePageSettings extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_homepage_settings';

    protected $fillable = [
        'hero_title',
        'hero_description',
        'hero_image',
        'about_title',
        'about_description',
        'about_image',
        'services_title',
        'services_description',
        'suppliers_title',
        'suppliers_description',
    ];
} 