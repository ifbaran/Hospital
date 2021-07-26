<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;

class WorkingHoursController extends Controller
{
    public function getWorkingHours($_date = '')
    {
        $returnArray = [];
        $date = $_date == '' ? date("Y-m-d") : $_date;
        $day = date('l',strtotime($date));
        $hours = WorkingHours::where('day',$day)->get();
        foreach ($hours as $k => $v) {
            $control = Appointment::where('appointmentDate', $date)
                ->where('isActive', 1)
                ->where(function ($control){
                    $control->orWhere('isActive', APPOINTMENT_WAITING);
                    $control->orWhere('isActive', APPOINTMENT_SUCCESS);
                })
                ->where('appointmentWorkingTime', $v['id'])->count();

            $explodedTime = explode('-',$v['hours']);
            $nowTime = date('H.i');
            $v['isActive'] = ($control == 0 and $explodedTime[0] > $nowTime);
            $returnArray[] = $v;
        }
        return response()->json($returnArray);
    }

    public function getWorkingStore(Request $request)
    {
        $all = $request->except('_token');
        WorkingHours::query()->delete();
        foreach ($all as $k => $v) {
            foreach ($v as $key => $value) {
                WorkingHours::create([
                    'day' => $k,
                    'hours' => $value
                ]);
            }
        }

        return response()->json($all);
    }

    public function getWorkingList()
    {
        $returnArray = [];
        $data = WorkingHours::all();

        foreach ($data as $k => $v)
        {
            $returnArray[$v['day']][] = $v['hours'];
        }
        return response()->json($returnArray);
    }
}
