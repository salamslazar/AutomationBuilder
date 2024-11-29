<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutionLog extends Model
{
    use HasFactory;

    protected $fillable = ['workflow_id','result','details'];

    public function workflow(){
        return $this->belongsTo(Workflow::class);
    }
}
