<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    protected $table = 'ext_area_daily_activity';
    use HasFactory;


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
