<?php

namespace App\Models;

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
