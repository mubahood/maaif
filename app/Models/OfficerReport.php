<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OfficerReport extends Model
{
    use HasFactory;

    public function get_all_items(){
        $activities  = [];
        
        $year = FinancialYear::find($this->year_id);
        if($year == null){
            die("Year not found.");
        }
        foreach (
            DB::select("SELECT DISTINCT annual_activity_id FROM ext_area_quaterly_activity
            WHERE `year` = '{$year->name}'
        ") as $act_id) {
            $activity = Activity::find($act_id->annual_activity_id);
            if($activity == null){
                continue;
            }
            $metrix = [];
            $budget = 0;
            $num_target_ben = 0;
            $num_planned = 0;
            foreach ([1,2,3,4] as $key => $q) {
                $metrix[$q]['budget'] = QuaterlyOutput::where([
                    'quarter' => $q,
                     'year' => $year->name,
                     'user_id' => $this->user_id,
                ])->sum('budget');
                $budget += $metrix[$q]['budget']; 

                $metrix[$q]['num_planned'] = QuaterlyOutput::where([
                    'quarter' => $q,
                     'year' => $year->name,
                     'user_id' => $this->user_id,
                ])->sum('num_planned');
                $num_planned += $metrix[$q]['num_planned'];

                $metrix[$q]['num_target_ben'] = QuaterlyOutput::where([
                    'quarter' => $q,
                     'year' => $year->name,
                     'user_id' => $this->user_id,
                ])->sum('num_target_ben');
                $num_target_ben += $metrix[$q]['num_target_ben'];
            }
            $activity->metrix = $metrix;
            $activity->budget = $budget;
            $activity->num_target_ben = $num_target_ben;
            $activity->num_planned = $num_planned;
             
            $activities[] = $activity;
        } 

        dd($activities);
   
        return  $activities;
    }  
    public function year(){
        return $this->belongsTo(FinancialYear::class,'year_id');
    }
    public function officer(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function district(){
        return $this->belongsTo(Location::class,'district_id');
    }
    public function department(){
        return $this->belongsTo(Location::class,'department_id');
    }
 
}
