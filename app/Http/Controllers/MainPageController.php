<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
            $appointments = Appointment::whereBetween('start_time',[$today,$limit])->get();//wyświetlamy najbliższe 4 tygodnie
        }
        else{
            $appointments = Appointment::where('employee_id',$currentUser->id)->whereBetween('start_time',[$today,$limit])->get();
        }
        
        foreach ($appointments as $appointment) {
            $event = [
                'start' => $appointment->start_time->setTimezone('UTC')->toIso8601String(),
                'end' => $appointment->calculateAppointmentEnd(),
            ];

            if ($appointment->client_id != $currentUser->id && !$currentUser->is_super_user) {
                $event['display'] = 'background';
                $event['color'] = 'red';
                $schedule [] = $event;
            } 
            else 
            {
                $event['title'] = $appointment->type->title;
                $event['extendedProps'] = [
                    'comment' => $appointment->comments,
                    'duration' => $appointment->type->duration,
                ];
            }
            $events[] = $event;
        }
        $types = AppointmentType::all();
        return view('panel_pages.calendar', compact('events','schedule','today','limit','types'));
    }

    public function validateAppointment(Request $request){
        $duration = $request->input('duration');
        $rules = [
            'type' => 'required|exists:appointment_types,id',
            'comment' => 'nullable|string|max:200',
            'date' => [
                'required',
                function ($attribute, $value, $fail) use ($duration) {
                    $date = Carbon::parse($value)->addHour();
    
                    // Convert "HH:MM:SS" duration to total minutes
                    $durationParts = explode(':', $duration);
                    $appointment_duration = ($durationParts[0] * 60) + $durationParts[1];
                    // Ensure the appointment is at least 1 hour from now
                    if (Carbon::now()->addHour()->gte($date)) {
                        return $fail("Termin jest zbyt wczesny");
                    }

                    $time = Carbon::createFromTime($date->hour, $date->minute, 0);
                    $earliestTime  = Carbon::createFromTimeString('08:00:00');

                    $closingTime = Carbon::createFromTimeString('20:00:00');
                    $latestTime = $closingTime->copy()->subMinutes($appointment_duration);

                    if (!$time->between($earliestTime, $latestTime, true)) { // Exclusive range
                        return $fail("Termin musi zgadzać się z godzinami otwarcia 8:00-20:00");
                    }
    
                    // Get the end time yes thats the worst code i ever wrote but the original $endDate is not working. It doesnt make sense to me either it needs to be refactored for sure but the project is due in 4 hours its 5am so im going to sleep:)
                    $endDate = $date->copy()->addMinutes($appointment_duration);
                    $year = ((int)$endDate->year);
                    $month = ((int)$endDate->month);
                    $day = ((int)$endDate->day);
                    $hour = ((int)$endDate->hour);
                    $minute = ((int)$endDate->minute);
                    $seconds = '00';
                    $worstStringEver = $year."-".$month."-".$day." ".$hour.":".$minute.":".$seconds;
                    $endDate = Carbon::parse($worstStringEver);
                    $dateOnly = $date->copy()->startOfDay();
                    $overlappingEvents = Appointment::whereBetween("start_time", [$dateOnly, $dateOnly->copy()->addDay()])->get();
                    foreach ($overlappingEvents as $event) {
                        $startTime = Carbon::parse($event->start_time);
                        $endTime = Carbon::parse($event->calculateAppointmentEnd());
                        if (
                            $date->between($startTime, $endTime, false) ||  // Start inside another event
                            $endDate->between($startTime, $endTime, false) ||  // End inside another event
                            ($date->lte($startTime) && $endDate->gte($endTime)) // Engulfing another event
                        ) {
                            return $fail("Wizyta koliduje z innym terminem.");
                        }
                    }
                }
            ],
        ];

        // Validate the incoming request data
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }
        // If validation passes, create the appointment
        $appointment = new Appointment();
        $appointment->appointment_type = $request->input('type');
        $appointment->client_id = Auth::id();
        $appointment->employee_id = 1;
        $appointment->start_time = Carbon::parse($request->input('date'))->addHour();
        $appointment->comments = $request->input('comment');
        $appointment->save();
        return response()->json([
            'success' => true,
        ]);

    }

    public function getProfile(){

        return view('panel_pages.profile');
    }
}
