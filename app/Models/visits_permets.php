<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visits_permets extends Model
{
    protected $table = "visits_permet";
    protected $fillable = ['permet','visit'];

}
