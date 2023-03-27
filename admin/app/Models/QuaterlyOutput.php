<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuaterlyOutput extends Model
{
    protected $table = 'ext_area_quaterly_activity';
    use HasFactory;


    function output_activities()
    {
        return $this->belongsToMany(QuaterlyOutputActivity::class, 'quaterly_output_id');
    }

    public function getActivitiesAttribute($vals)
    {
        return explode(',', $vals);
    }
    public function setActivitiesAttribute($vals)
    {
        return implode(',', $vals);
    }
    public function getEntreprizesAttribute($vals)
    {
        return explode(',', $vals);
    }
    public function getTopicAttribute($vals)
    {
        $arr = explode(',', $vals);
        return $arr;
        $texts = "";
        $isFirst = true;
        foreach ($arr as $key => $txt) {
            $a =  AnnualOutput::find($txt);
            if ($a) {
                if ($isFirst) {
                    $isFirst = false;
                } else {
                    $texts .= ',';
                }
                $texts .= $a->key_output;
            }
        }

        if (strlen($texts) < 2) {
            $texts = $vals;
        }
        return $texts;
    }
    public function getTopicTextAttribute($vals)
    {

        $texts = "";
        $isFirst = true;
        $arr = $this->topic;

        foreach ($arr as $key => $txt) {
            $a =  AnnualOutput::find($txt);
            if ($a) {
                if ($isFirst) {
                    $isFirst = false;
                } else {
                    $texts .= ',';
                }
                $texts .= $a->key_output;
            }
        }

        if (strlen($texts) < 2) {
            $texts = $vals;
        }
        return $texts;
    }



    public static function boot()
    {

        parent::boot();
        self::creating(function ($m) {
            return QuaterlyOutput::prepare($m);
        });


        self::updating(function ($m) {
            return QuaterlyOutput::prepare($m);
        });
    }



    public static function prepare($m)
    {
        $a = AnnualOutput::find($m->key_output_id);
        if ($a != null) {
            $m->annual_id = $a->annual_workplan_id;
        } else {
            throw new Exception("Annual plan not found.", 1);
        }
        return $m;
    }
    public function setTopicAttribute($value)
    {
        $this->attributes['topic'] = implode(',', $value);
    }


    public function setEntreprizesAttribute($value)
    {
        $this->attributes['entreprizes'] = implode(',', $value);
    }


    public function work_plan()
    {
        return $this->belongsTo(AnnualWorkplan::class, 'annual_id');
    }


    public function output()
    {
        /*  $y = AnnualOutput::find($this->annual_id);
        if (
            $y == null 
        ) {
 
            $outs = [];
            foreach (AnnualOutput::where([
                'user_id' => $this->user_id
            ])->get() as $key => $val) {
                $outs[] = $val->id;
            }
            if (count($outs) > 0) {
                shuffle($outs);
                $this->annual_id = $outs[0];
                $this->save();
            } else {
                $this->annual_id = 1;
                $this->save();
            }
        } */
        return $this->belongsTo(AnnualOutputHasActivity::class, 'key_output_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function daily_actovities()
    {
        return $this->hasMany(DailyActivity::class, 'quarterly_activity_id');
    }

    public function getNumReachedAttribute()
    {
        $tot = 0;
        foreach ($this->daily_actovities as $v) {
            $tot += $v->num_ben_total;
        }
        return $tot;
    }

    protected $appends = ['topic_text', 'num_reached'];
}
