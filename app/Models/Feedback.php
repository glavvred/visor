<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'excel_table_test';
    public $timestamps = false;

    protected $fillable = [
        'tema_v_otcete',
        'subjekt',
        'date_with_time',
        'istocnik',
        'url_post',
        'url_kommentarii',
        'avtor',
        'kolicestvo_podpiscikov',
        'gorod',
        'raion',
        'ocenka_krai',
        'krai_glava',
        'ocenka_glavi',
        'kommentarii',
        'laiki',
        'reposti',
        'prosmotri',
        'ssilka_na_profil',];


}
