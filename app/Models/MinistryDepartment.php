<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinistryDepartment extends Model
{
    use HasFactory;
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($m) {
            throw new Exception("You cannot delete this item.", 1);
        }); 
    }


    public function directorate()
    {
        return $this->belongsTo(Directorate::class,'directorate_id');
    }
}
