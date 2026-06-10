<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ant_visitors extends Model
{
    protected $table = "antenne_visitors";
    protected $fillable = ['firstname','lastname','cin','nin','position','id_type','attachment'];

}
