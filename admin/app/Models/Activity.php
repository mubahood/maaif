<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'ext_activitys';

    public static function getArray()
    {
        $items = [];
        foreach (Activity::where([])->orderBy('name', 'Asc')->get() as $key => $v) {
            $items[$v->id] = $v->name;
        }
        return $items;
    }

    public function cat()
    {
        return $this->belongsTo(ActivityCategory::class,'category');
    }
    public function getNameTextAttribute()
    {
        $_name = "";
        if($this->cat != null){ 
            $_name  = $this->cat->name . ' - ';
        }
        return    $_name.  $this->name;
    }
    protected $appends = ['name_text'];
}
