<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $table = 'ext_topics';

    public function getNameTextAttribute()
    {
        if ($this->cat == null) {
            return $this->name;
        }
        return $this->cat->name . " - " . $this->name;
    }


    public function cat()
    {
        return $this->belongsTo(TopicCategory::class, 'category');
    }

    //TopicCategory
    protected $appends = ['name_text'];
}
