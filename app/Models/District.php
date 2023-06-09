<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'district';


    public function users()
    {
        return $this->hasMany(Administrator::class, 'district_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
