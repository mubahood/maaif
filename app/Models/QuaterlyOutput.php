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
            $a =  Topic::find($txt);
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

    public function getTopicsAttribute($vals)
    {
        $arr = [];
        foreach ($this->topic as  $txt) {
            $a =  Topic::find($txt);
            if ($a) {
                $arr[$a->id] = $a->name;
            }
        } 
        return $arr;
    }
    public function getTopicTextAttribute()
    {

        $texts = "";
        $isFirst = true;
        $arr = $this->topic;

        if (!is_array($arr)) {
            return "";
        }
        foreach ($arr as $key => $txt) {
            $a =  Topic::find($txt);
            if ($a) {
                if ($isFirst) {
                    $isFirst = false;
                } else {
                    $texts .= ',';
                }
                $texts .= $a->name;
            }
        }

        if (strlen($texts) < 2) {
            $texts = 'No topic';
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
            $m->annual_id = 1;
            $m->save();
            //  throw new Exception("Annual plan not found.", 1);
        }


        $wp = AnnualWorkplan::find($m->annual_id);
        if ($wp == null) {
            throw new Exception("Annual Workplan not found.", 1);
        }
        if ($wp->department == null) {
            throw new Exception("Annual Workplan Department not found.", 1);
        }
        if ($wp->district == null) {
            throw new Exception("Annual Workplan District not found.", 1);
        }

        $m->department_id = $wp->department_id;
        $m->district_id = $wp->district_id;
        $m->year = $wp->year;

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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
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


    public function get_curried()
    {
        $_daily_activities = count($this->daily_actovities);
        $_num_planned = ((int)($this->num_planned));

        if ($_num_planned == 0) {
            if ($_daily_activities > 0) {
                return 100;
            }
            return 0;
        }

        $ans = ($_daily_activities / $_num_planned) * 100;

        if ($ans > 100) {
            return 100;
        }

        return ceil($ans);
    }

    public function get_benefitiaries_percentage()
    {
        $_num_reached = $this->num_reached;
        $_num_planned = $this->num_target_ben;

        if ($_num_reached == 0) {
            if ($_num_planned > 0) {
                return 0;
            }
            return $_num_planned;
        }

        if ($_num_planned == 0) {
            return 0;
        }
        $ans = ($_num_reached / $_num_planned) * 100;

        if ($ans > 100) {
            return 100;
        }
        return ceil($ans);
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
    public function getNameAttribute()
    {
        $u = User::find($this->user_id);
        $by_text = "";
        if ($u != null) {
            $by_text = " by " . $u->name;
        }
        $name = "";
        $name = "#" . $this->id . " - " . $this->year . ", UGX {$this->budget} {$by_text} - Topics:  " . $this->topic_text;
        return $name;
    }

    protected $appends = ['topic_text', 'num_reached', 'name','topics'];
}
