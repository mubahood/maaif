<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
                throw new Exception("You cannot create multiple annual work plan in same distrit, same department in same year.", 1);
            }

            $year = FinancialYear::where('name', $m->year)->first();
            if ($year == null) {
                die($m->year . " Year not found!");
            }
            $m->financial_year_id = $year->id;
        });

        self::updating(function ($m) {
            $year = FinancialYear::where('name', $m->year)->first();
            if ($year == null) {
                die($m->year . " Year not found!");
            }
            $m->financial_year_id = $year->id;
        });
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function financial_year()
    {
        return $this->belongsTo(FinancialYear::class);
    } 

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }


    public function annual_outputs()
    {
        return $this->hasMany(AnnualOutput::class, 'annual_workplan_id');
    }

    public function getNameAttribute()
    {
        return   $this->district->name . ", " . $this->department->department . ' - ' .  $this->year;
    }
    public function getBugetTextAttribute()
    {
        $sql = "SELECT SUM(budget) AS s FROM  ext_area_quaterly_activity WHERE annual_id = $this->id";
        $s = DB::select($sql);
        return $s[0]->s;
    }

    public function getBugetByQuater($q)
    {
        $sql = "SELECT SUM(budget) AS s FROM  ext_area_quaterly_activity WHERE annual_id = $this->id AND quarter = $q";
        $s = DB::select($sql);
        return $s[0]->s;
    }

    public function getQuaterlyActivities($q)
    {
        return QuaterlyOutput::where([
            'annual_id' => $this->id,
            'quarter' => $q
        ])->get();
    }

    public function quaterly_outputs()
    {
        return $this->hasMany(QuaterlyOutput::class, 'annual_id');
    }

    public static function generate_work_plan($year)
    {
        foreach (District::all() as $dist) {
            if ($dist->id < 1) {
                continue;
            }
            foreach (Department::all() as $dept) {
                $old_plan = AnnualWorkplan::where([
                    'district_id' => $dist->id,
                    'department_id' => $dept->id,
                    'financial_year_id' => $year->id,
                ])->first();
                if ($old_plan != null) {
                    continue;
                }

                $plan = new AnnualWorkplan();
                $plan->district_id = $dist->id;
                $plan->department_id = $dept->id;
                $plan->financial_year_id = $year->id;
                $plan->year = $year->year;
                //$plan->save(); 
             
            } 
        } 
    }
    /* 
	
year	
description	
*/



    /* 
    "id" => 1
    "created_at" => "2023-03-06 14:22:01"
    "updated_at" => "2023-04-05 11:54:50"
    "district_id" => 0
    "department_id" => 1
    "year" => "2019/2020"
    "description" => null
    "financial_year_id" => 1
    
    */

    protected $appends = ['name', 'buget_text'];
}
