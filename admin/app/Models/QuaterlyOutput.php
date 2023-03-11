<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuaterlyOutput extends Model
{
    protected $table = 'ext_area_quaterly_activity';
    use HasFactory;

    public function getTopicAttribute($vals)
    {
        $arr = explode(',', $vals);
        $texts = "";
        $isFirst = true;
        foreach ($arr as $key => $txt) {
            $a =  AnnualOutput::find($txt);
            if ($a) {
                if ($isFirst) {
                    $isFirst = false;
                } else {
                    $texts .= ',';
                }
                $texts .= $a->key_output;
            }
        }

        if (strlen($texts) < 2) {
            $texts = $vals;
        }

        return $texts;
    }

    public function output()
    {
        $y = AnnualOutput::find($this->annual_id);
        dd($y);
        if (
            $y == null 
        ) {


            $outs = [];
            foreach (AnnualOutput::where([
                'user_id' => $this->user_id
            ])->get() as $key => $val) {
                $outs[] = $val->id;
            }
            if (count($outs) > 0) {
                shuffle($outs);
                $this->annual_id = $outs[0];
                $this->save();
            } else {
                $this->annual_id = 1;
                $this->save();
            }
        }
        return $this->belongsTo(AnnualOutput::class, $this->annual_id);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
