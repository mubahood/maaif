<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    protected $table = 'ext_area_daily_activity';
    use HasFactory;

    
    public static function boot()
    {
        parent::boot(); 

        self::creating(function ($m) {
            return DailyActivity::prepare($m);
        });

        self::updating(function ($m) {
            return DailyActivity::prepare($m);
        });
    }


    public static function prepare($m)
    {
        $wp = QuaterlyOutput::find($m->quarterly_activity_id);
        if ($wp == null) { 
            throw new Exception("Quaterly Output not found.", 1);
        }
        if ($wp->department == null) {
            throw new Exception("Department not found.", 1);
        } 
        if ($wp->district == null) {
            throw new Exception("District not found.", 1);
        }

        $m->department_id = $wp->department_id;
        $m->district_id = $wp->district_id;
 
        return $m;
    }
 


    public function getTopicTextAttribute()
    {
        $t = Topic::find($this->topic);
        if ($t == null) {
            return '-';
        }
        return $t->name;
    }
    public function getEntrepriseTextAttribute()
    {
        $t = Enterprise::find($this->topic);
        if ($t == null) {
            return '-';
        }
        return $t->name;
    }


    public function activity()
    {
        return $this->belongsTo(QuaterlyOutput::class, 'quarterly_activity_id');
    }


    public function getVillageTextAttribute()
    {
        $t = Village::find($this->village_id);
        if ($t == null) {
            return '-';
        }
        return $t->name;
    }


    protected $appends = ['topic_text', 'entreprise_text', 'village_text'];
}
