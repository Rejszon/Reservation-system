<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDO;

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
        $schedule = [];
        $currentUser = Auth::user();
        $today = Carbon::today();
        $limit = $today->copy()->addDays(28);
        if (!$currentUser->is_super_user) {
            $scheduleAppointments = Appointment::whereBetween('start_time',[$today,$limit])->get();//wyświetlamy najbliższe 4 tygodnie
            $appointments = $scheduleAppointments->filter(function ($appointment) use($currentUser){
                return $appointment->client_id == $currentUser->id;
            });// nie filtrujemy w bazie bo potrzebujemy obu
        }
        else{
            $appointments = Appointment::where('employee_id',$currentUser->id)->whereBetween('start_time',[$today,$limit])->get();
        }
        
        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
                'start' => $appointment->start_time->setTimezone('UTC')->toIso8601String(),
                'end' => $appointment->calculateAppointmentEnd(),
                'extendedProps'=> [
                    'description' => $appointment->type->description,
                ],
            ];
        }
        if (!$currentUser->is_super_user) {
            foreach ($scheduleAppointments as $appointment) {
                $schedule[] = [
                    'start' => $appointment->start_time,
                    'end' => $appointment->calculateAppointmentEnd(),
                ];
            }
        } 
        return view('panel_pages.calendar', compact('events','schedule','today','limit'));
    }

    public function getProfile(){

        return view('panel_pages.profile');
    }
}
