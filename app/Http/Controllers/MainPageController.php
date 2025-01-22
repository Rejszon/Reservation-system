<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{
    public function getIndex(){
        
        return view('main_pages.index');
    }

    public function getServices(){
        
        return view('main_pages.services');
    }

    public function getContact(){
        
        return view('main_pages.contact');
    }

    public function getCalendar(){
        $events = [];
        $currentUser = Auth::user();
        if ($currentUser->is_super_user) {
            $appointments = Appointment::where('employee_id',$currentUser->id)->get();
        }
        else{
            $appointments = Appointment::where('client_id',$currentUser->id)->get();
        }

        foreach ($appointments as $appointment) {
            $duration = $appointment->type->duration;
            list($hours, $minutes, $seconds) = explode(':',$duration);
            $end = Carbon::parse($appointment->start_time)->addHours((int)$hours)->addMinutes((int)$minutes)->addSeconds((int)$seconds);
            $events[] = [
                'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
                'start' => $appointment->start_time->setTimezone('UTC')->toIso8601String(),
                'end' => $end,
                'extendedProps'=> [
                    'description' => 'opis',
                ],
            ];
        }
 
        return view('panel_pages.calendar', compact('events'));
    }

    public function getProfile(){
 
        return view('panel_pages.profile');
    }
}
