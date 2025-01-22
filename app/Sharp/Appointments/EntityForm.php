<?php

namespace App\Sharp\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\User;
use Code16\Sharp\Form\Fields\SharpFormDateField;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Layout\FormLayout;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Illuminate\Support\Facades\Log;

class EntityForm extends SharpForm
{
    public function buildFormFields(FieldsContainer $formFields): void
    {
        $formFields->addField(
			SharpFormSelectField::make('client_id',User::query()->pluck('name','id')->toArray())
				->setLabel('Nazwisko pacjenta')
				->setDisplayAsDropdown()
		)->addField(
			SharpFormDateField::make('start_time')
				->setLabel('Termin')
				->setMondayFirst()
				->setHasTime()
		)->addField(
			SharpFormTextField::make('special_price')
				->setLabel('Specjalna cena')
		)->addField(
			SharpFormSelectField::make('appointment_type',AppointmentType::query()->pluck('title','id')->toArray())
				->setLabel('Typ wizyty')
				->setDisplayAsDropdown()
		);
    }

	public function buildFormLayout(FormLayout $formLayout): void
	{
		$formLayout
        ->addColumn(12, function(FormLayoutColumn $column) {
            $column->withSingleField('client_id');
            $column->withSingleField('start_time');
            $column->withSingleField('special_price');
            $column->withSingleField('appointment_type');
    	});
	}

	public function find($id): array
	{
		return Appointment::find($id)->toArray();
	}
	
	public function update($id, array $data)
    {
		$appointment = $id ? Appointment::findOrFail($id) : new Appointment;
		
		$data['employee_id'] = sharp_user()->id;
		$appointment->fill($data);
		Log::info($data);
		$appointment->save();
		
    }
}
