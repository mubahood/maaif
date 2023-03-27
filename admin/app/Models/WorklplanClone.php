<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorklplanClone extends Model
{
    use HasFactory;
    public static function boot()
    {
        parent::boot();
        self::created(function ($m) {
            return WorklplanClone::do_cone($m);
        });
        self::deleting(function ($m) {
            try {
                QuaterlyOutput::where([
                    'clone_id' => $m->id
                ])->delete();
            } catch (\Throwable $th) {
                throw new Exception("Failed to delete items.", 1);
            }
        });
    }

    public static function do_cone($m)
    {
        $source = User::find($m->source_id);
        if ($source == null) {
            return;
        }
        if ($source->activities == null) {
            return;
        }

        $num_activities = 0;
        $num_budget = 0;
        foreach ($source->activities as $v) {
            $newData = $v->replicate();
            $newData->created_at = now();
            $newData->user_id = $m->destination_id;
            $newData->created_by = $v->created_by;
            $newData->clone_id = $m->id;
            $num_budget += $v->budget;
            $num_activities++;
            $newData->save();
        }
        $m->processed  = 'Yes';
        $m->description = "Cloned $num_activities activities, total budget UGX " . number_format($num_budget) . ".";
        $m->save();
    }
}
