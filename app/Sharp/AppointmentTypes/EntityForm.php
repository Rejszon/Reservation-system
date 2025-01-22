<?php

namespace App\Sharp\AppointmentTypes;

use App\Models\AppointmentType;
use Code16\Sharp\Form\Fields\SharpFormTextareaField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Layout\FormLayout;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use Code16\Sharp\Utils\Fields\FieldsContainer;

class EntityForm extends SharpForm
{
	protected ?string $formValidatorClass = AppointmentTypeValidator::class;

    public function buildFormFields(FieldsContainer $formFields): void
    {
        $formFields->addField(
			SharpFormTextField::make('title')
				->setLabel('Tytuł usługi')
		)->addField(
			SharpFormTextField::make('duration')
				->setLabel('Czas trwania')
				->setHelpMessage("Prosze podać w formacie Godziny:minuty:sekundy. Przykładowo 1:30:00 - to jest 1 godzina i 30 minut")
		)->addField(
			SharpFormTextField::make('price')
				->setLabel('Cena')
		)->addField(
			SharpFormTextareaField::make('description')
				->setLabel('Opis')
				->setRowCount(5)
		);
    }

	public function buildFormLayout(FormLayout $formLayout): void
	{
		$formLayout
        ->addColumn(7, function(FormLayoutColumn $column) {
            $column->withSingleField('title');
            $column->withSingleField('duration');
            $column->withSingleField('price');
    	})
		->addColumn(5, function(FormLayoutColumn $column) {
            $column->withSingleField('description');
    	});
	}

	public function find($id): array
	{
		return AppointmentType::find($id)->toArray();
	}
	
	public function update($id, array $data)
    {
		$type = $id ? AppointmentType::findOrFail($id) : new AppointmentType();
		$type->fill($data);
		$type->save();
    }
}
