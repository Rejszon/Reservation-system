<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'start_time',
        'comments',
        'client_id',
        'employee_id',
        'appointment_type',
    ];

    protected function casts(){
        return [
            'start_time' => 'datetime',
        ];
    }

    public function client()
    {
        return $this->belongsTo('App\Models\User', 'client_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\User', 'employee_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\AppointmentType','appointment_type');
    }
}
