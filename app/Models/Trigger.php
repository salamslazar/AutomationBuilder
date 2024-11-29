<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    use HasFactory;

    protected $fillable = ['name','type','params','workflow_id'];

    public function workflow(){
        return $this->belongsTo(Workflow::class);
    }

}
