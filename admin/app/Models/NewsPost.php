<?php

namespace App\Models;

use OpenAdmin\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function created_by()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }
}
