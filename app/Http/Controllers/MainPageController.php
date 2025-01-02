<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
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
            $events[] = [
                'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
                'start' => $appointment->start_time->setTimezone('UTC')->toIso8601String(),
                'end' => $appointment->finish_time->setTimezone('UTC')->toIso8601String(),
            ];
        }
 
        return view('panel_pages.calendar', compact('events'));
    }
    
    public function getProfile(){
 
        return view('panel_pages.profile');
    }
}
