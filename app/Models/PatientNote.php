<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientNote extends Model
{

    protected $table = 'patient_notes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'subject',
        'content',
    ];

    protected function casts(){
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
