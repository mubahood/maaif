<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualOutput extends Model
{
    use HasFactory;
    protected $table = 'ext_area_annual_outputs';

    public static function getArray($user_id)
    {
        $items = [];
        foreach (AnnualOutput::where(['user_id' => $user_id])->orderBy('key_output', 'Asc')->get() as $key => $v) {
            $items[$v->id] = $v->key_output;
        }
        return $items;
    }

    function output_activities()
    {
        return $this->belongsToMany(Activity::class, 'annual_output_has_activities');
    }
    function annual_workplan()
    {
        return $this->belongsTo(AnnualWorkplan::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getActivitiesTextAttribute($vals)
    {
        if (count($this->output_activities) < 1) {
            return '-';
        }

        $texts = "";
        $isFirst = true;
        foreach ($this->output_activities as $key => $txt) {

            if ($isFirst) {
                $isFirst = false;
            } else {
                $texts .= ',';
            }
            $texts .= $txt->name;
        }

        if (strlen($texts) < 2) {
            $texts = $vals;
        }

        return $texts;
    }

    protected $appends = ['activities_text'];
}
