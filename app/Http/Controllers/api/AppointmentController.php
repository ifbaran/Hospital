<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use http\Env\Response;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function storeAppointment(Request $request)
    {
        $returnArray = [];
        $returnArray['status'] = false;
        $appointmentRequest = $request->all();
        $control = Appointment::where('appointmentDate', $appointmentRequest['appointmentDate'])
            ->where('appointmentWorkingTime', $appointmentRequest['appointmentWorkingTime'])->count();

        if ($control != 0)
        {
            $returnArray['message'] = "There is an appointment on this date.";
            return response()->json($returnArray);
        }

        $createAppointment = Appointment::create($appointmentRequest);
        if ($createAppointment)
        {
            $returnArray['status'] = true;
            $returnArray['message'] = "Your appointment has been created successfully";
        }

        else
        {
            $returnArray['message'] = "Your appointment could not be saved. Please contact us! ";
        }
        return response()->json($returnArray);
    }
}
