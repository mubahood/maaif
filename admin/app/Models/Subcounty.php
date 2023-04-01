<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;

class Subcounty extends Model
{
    use HasFactory;
    protected $table = 'subcounty';


    public function users()
    {
        return $this->hasMany(Administrator::class, 'subcounty_id');
    }
    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function getNameTextAttribute()
    {
        $name = "";
        $county = $this->county;
        if ($county != null) {
            $name = $county->name . ", ";
            $district = $county->district;
            if ($district != null) {
                $name = $district->name . ", " . $name;
            }
        }
        $name .= $this->name;
        return $name;
    }

    protected $appends = ['name_text'];
}
