<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visitors extends Model
{
    protected $table = "visitors";
    protected $fillable = ['firstname','lastname','cin','nin','position','id_type','attachment'];

}
