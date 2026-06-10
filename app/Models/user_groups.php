<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_groups extends Model
{
    protected $table="user_groups";
    protected $fillable=['a_user','a_group','is_head'];
    public $timestamps=false;
}
