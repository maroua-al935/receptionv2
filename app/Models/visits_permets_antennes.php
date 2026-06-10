<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visits_permets_antennes extends Model
{
    protected $table = "antenne_visits_permet";
    protected $fillable = ['permet','visit'];

}
