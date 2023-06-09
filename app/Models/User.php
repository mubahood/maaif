<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as RelationsBelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    protected $table = 'user';

    public function activities()
    {
        return $this->hasMany(QuaterlyOutput::class, 'user_id');
    }


    public function bugdet()
    {
        $budget = 0;
        foreach ($this->activities as $key => $v) {
            $budget += $v->budget;
        }
        return $budget;
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function designation()
    {
        return $this->belongsTo(UserCategory::class, 'user_category_id');
    }

    public function department()
    {
        $dep = Department::find($this->department_id);
        if ($dep == null) {
            $this->department_id = 1;
            $this->save();
            //return "-";
        }
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
