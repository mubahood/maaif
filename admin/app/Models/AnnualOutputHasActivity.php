<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualOutputHasActivity extends Model
{
    use HasFactory;

    public function getNameTextAttribute()
    {
        $act = $this->activity;
        if ($act == null) {
            $this->activity_id = 1;
            $this->save();
            $act = $this->activity;
        }
        $act_name = "-";
        if ($act != null) {
            $act_name = $act->name;
        }

        $annual_output = AnnualOutput::find($this->annual_output_id);
        if ($annual_output == null) {
            $this->annual_output_id = 1;
            $this->save();
            $annual_output = AnnualOutput::find($this->annual_output_id);
        }
        return  $annual_output->year . ' - ' . $act_name;
    }
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
    public function annual_output()
    {
        return $this->belongsTo(AnnualOutput::class, 'annual_output_id');
    }

    protected $appends = ['name_text'];
}
