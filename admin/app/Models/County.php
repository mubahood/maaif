<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;
    protected $table = 'county';


    public function sub_counties()
    {
        return $this->hasMany(Subcounty::class, 'county_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
