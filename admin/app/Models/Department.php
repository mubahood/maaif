<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory; 
    public function director()
    {
        return $this->belongsTo(User::class,'directorate_id');
    }
}
