<?php

namespace App\Models;

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

}
