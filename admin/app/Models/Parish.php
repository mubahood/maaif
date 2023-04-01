<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    use HasFactory;
    protected $table = 'parish';



    public function subcounty()
    {
        return $this->belongsTo(Subcounty::class, 'subcounty_id');
    }
}
