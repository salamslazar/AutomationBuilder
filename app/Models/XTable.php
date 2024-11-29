<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XTable extends Model
{
    use HasFactory;

    protected $fillable = ['name','my_table_id'];
}
