<?php

namespace App\Sharp\PatientNotes;

use App\Models\PatientNote;
use App\Models\User;
use Code16\Sharp\Form\Fields\SharpFormEditorField;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Layout\FormLayout;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use Code16\Sharp\Utils\Fields\FieldsContainer;

class EntityForm extends SharpForm
{
    public function buildFormFields(FieldsContainer $formFields): void
    {
        $formFields->addField(
			SharpFormSelectField::make('user_id',User::query()->pluck('name','id')->toArray())
				->setLabel('Nazwisko pacjenta')
				->setDisplayAsDropdown()
		)
		->addField(
			SharpFormTextField::make('subject')
				->setLabel('Temat notatki')
		)->addField(
			SharpFormEditorField::make('content')
				->setLabel('Treść notatki')
				->showToolbar()
				->setToolbar([
					SharpFormEditorField::B, 
					SharpFormEditorField::I,
					SharpFormEditorField::HIGHLIGHT,
					SharpFormEditorField::UL,
					SharpFormEditorField::H1,
					//SharpFormEditorField::UPLOAD_IMAGE, TODO implement that
					SharpFormEditorField::A,
				])
		);
    }

	public function buildFormLayout(FormLayout $formLayout): void
	{
		$formLayout
        ->addColumn(5, function(FormLayoutColumn $column) {
            $column->withSingleField('user_id');
            $column->withSingleField('subject');
    	})
    	->addColumn(7, function(FormLayoutColumn $column) {
            $column->withSingleField('content');
    	});
	}

	public function find($id): array
	{
		return PatientNote::find($id)->toArray();
	}
	
	public function update($id, array $data)
    {
		$note = $id ? PatientNote::findOrFail($id) : new PatientNote;
		
		$note->fill($data);
		$note->save();
		
    }
}
