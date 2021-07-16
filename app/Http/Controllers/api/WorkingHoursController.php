<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;

class WorkingHoursController extends Controller
{
    public function getWorkingHours($_date='')
    {
        $returnArray = [];
        $date = $_date == '' ? date("Y-m-d") : $_date;
        $hours = WorkingHours::all();
        foreach ($hours as $k => $v) {
            $control = Appointment::where('appointmentDate',$date)->where('appointmentWorkingTime',$v['id'])->count();
            $v['isActive'] = $control == 0;
            $returnArray[] = $v;
        }
        return response()->json($returnArray);
    }
}
