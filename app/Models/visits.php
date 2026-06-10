<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visits extends Model
{
    protected $table="visits";
    protected $fillable=['visitor','category','entry_date','exit_date','emp_visited','service_emp_visited','badge_n','status','has_host','subject','is_deleted','organization', 'observations'];
    public $timestamps=false;
}
