<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    protected $table = 'appointment_types';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'duration',
        'price',
    ];
    public function getDuration()
    {
        return Carbon::parse($this->duration)->format("H:i");
    }

}
