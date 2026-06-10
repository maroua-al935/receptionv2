<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    protected $table="groups";
    protected $fillable=['group_name','group_full_dn','group_dn'];
    public $timestamps=false;
}
