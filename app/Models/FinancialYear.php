<?php

namespace App\Models;

use Dflydev\DotAccessData\Util;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FinancialYear extends Model
{
    use HasFactory;

    public function workplans()
    {
        return $this->hasMany(AnnualWorkplan::class, 'financial_year_id');
    }

    public static function generate_plans($m)
    {
        ini_set('memory_limit', '-1'); 
        set_time_limit(-1); 
        foreach (District::all() as $dis) {
            if ($dis->id == 0) {
                continue;
            }
            foreach (Department::all() as $dep) {
                if ($dep->id == 1) {
                    continue;
                }
                $plan = AnnualWorkplan::where([
                    'district_id' => $dis->id,
                    'department_id' => $dep->id,
                    'financial_year_id' => $m->id,
                ])->first();

                if ($plan != null) {
                    continue;
                }

                $plan = new AnnualWorkplan();
                $plan->district_id = $dis->id;
                $plan->department_id = $dep->id;
                $plan->year = $m->name;
                $plan->financial_year_id = $m->id;
                $plan->save();
            }
        }
    }
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($m) {
            throw new Exception("This item cannot be deleted.", 1);
        });

        self::creating(function ($m) {
            $y = FinancialYear::where('name', $m->name)->first();
            if ($y != null) {
                throw new Exception("This year already exist.", 1);
            }
            if ($m->active == 1) {
                DB::update("UPDATE financial_years SET active = 0");
            }
        });

        self::updated(function ($m) {
            FinancialYear::generate_plans($m);
        });

        self::created(function ($m) {
            FinancialYear::generate_plans($m);
        });

        self::updating(function ($m) {
            if ($m->active == 1) {
                DB::update("UPDATE financial_years SET active = 0");
            }
            if ($m->data_entry == 1) {
                DB::update("UPDATE financial_years SET data_entry = 0");
            }
        });
    }
}
