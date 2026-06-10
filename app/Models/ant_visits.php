<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ant_visits extends Model
{
    protected $table="antenne_visits";
    protected $fillable=['visitor','category','entry_date','exit_date','emp_visited','status','has_host','subject','is_deleted','organization','ant_location'];
    public $timestamps=false;
    
}
