<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();


        self::created(function ($m) {
            //$m->doGen();
        });

        self::updated(function ($m) {
            //$m->doGen();
        });
    }



    public function getUsersAttribute($vals)
    {
        return explode(',', $vals);
    }
    public function setUsersAttribute($value)
    {
        $this->attributes['users'] = implode(',', $value);
    }

    public function doGen()
    {
        if ($this->type == 'Extension officers') {
            $this->doGenForUsers();
        } elseif ($this->type == 'Departmental') {
            $this->doGenForDepartments();
        }
        $this->generated = "Yes";
        $this->save();
    }
    public function doGenForDepartments()
    {
        $dep = Department::find($this->departments);
        if ($dep == null) {
            return;
        }
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        $u = User::find($this->user_id);
        $r = OfficerReport::where([
            'district_id' => $u->district_id,
            'type' => 'department',
            'year_id' => $this->year_id,
        ])->first();
        if ($r == null) {
            $r = new OfficerReport();
        }
        $r->type = 'department';
        $r->user_id = $u->id;
        $r->district_id = $u->district_id;
        $r->year_id = $this->year_id;
        $r->report_generator_id = $this->id;
        $r->generated_by = $this->user_id;
        $r->comment = null;
        $r->submited = 'No';
        $r->department_id = $dep->id;
        $r->total_budget = null;
        $r->save();
    }
    public function doGenForUsers()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        $users = [];
        if ($this->for_all_members == 'Specific') {
            if (is_array($this->users)) {
                foreach ($this->users as $u_id) {
                    $_user = User::find($u_id);
                    if ($_user != null) {
                        $users[] = $_user;
                    }
                }
            }
        } else {
            $u = User::find($this->user_id);
            if ($u != null) {
                $users = User::where([
                    'district_id' => $u->district_id,
                    'department_id' => $u->department_id,
                ])->get();
            }
        }
        foreach ($users as $key => $u) {

            $r = OfficerReport::where([
                'user_id' => $u->id,
                'year_id' => $this->year_id,
            ])->first();
            if ($r == null) {
                $r = new OfficerReport();
            }
            if ($r == null) {
                continue;
            }

            $r->user_id = $u->id;
            $r->district_id = $u->district_id;
            $r->department_id = $u->department_id;
            $r->year_id = $this->year_id;
            $r->report_generator_id = $this->id;
            $r->generated_by = $this->user_id;
            $r->comment = null;
            $r->submited = 'No';
            $r->total_budget = null;
            $r->save();
        }
    }
}
