<?php

namespace App\Sharp\AppointmentTypes;

use App\Rules\Duration;
use Code16\Sharp\Form\Validator\SharpFormRequest;

class AppointmentTypeValidator extends SharpFormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'duration' => ['required', new Duration],
        ];
    }
}
