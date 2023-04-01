<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory; 
    protected $table = 'village';
    public function parish()
    {
        return $this->belongsTo(Parish::class, 'parish_id');
    } 
    
}
