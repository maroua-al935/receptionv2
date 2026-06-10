<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ant_user extends Model
{
    protected $table="antenne_users";
    protected $fillable=['ant_user','ant_group','is_head'];
    public $timestamps=false;
}
