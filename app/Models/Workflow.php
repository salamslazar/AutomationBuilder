<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = ['name','is_active'];

    public function triggers(){
        return $this->hasMany(Trigger::class);
    }

    function conditions() {
        return $this->hasOne(Condition::class);
    }

    function actions() {
        return $this->hasMany(Action::class);
    }

    function execution_logs() {
        return $this->hasMany(ExecutionLog::class);
    }
}
