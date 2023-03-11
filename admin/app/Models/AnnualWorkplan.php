<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualWorkplan extends Model
{
    use HasFactory;


    public static function boot()
    {
        parent::boot();
        self::deleting(function ($m) {
            throw new Exception("You cannot delete this item.", 1);
        });

        self::creating(function ($m) {
            $an = AnnualWorkplan::where([
                'district_id' => $m->district_id,
                'department_id' => $m->department_id,
                'year' => $m->year,
            ])->first();

            if ($an != null) {
                throw new Exception("You cannot create item anual work plan in same distrit, same department in same year.", 1);
            }
        });
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }


    public function annual_outputs()
    {
        return $this->hasMany(AnnualOutput::class, 'annual_workplan_id');
    }

    public function getNameAttribute()
    {
        return   $this->district->name . ", " . $this->department->department . ' - ' .  $this->year; 
    }

    protected $appends = ['name'];
}
