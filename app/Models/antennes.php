<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class antennes extends Model
{
    protected $table="antennes";
    protected $fillable=['antenne_name','antenne_full_dn','antenne_dn'];
    public $timestamps=false;
}
