<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use HasFactory;
    protected $guarded = [];
    static function getString($workingHourId)
    {
        $control = WorkingHours::where('id',$workingHourId)->count();

        if ($control != 0)
        {
            $workingHour = WorkingHours::where('id', $workingHourId)->get();
            return $workingHour[0]['hours'];
        }
        else
        {
            return "";
        }
    }
}
