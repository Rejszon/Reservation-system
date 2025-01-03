<?php

namespace App\Sharp\PatientNotes;

use App\Models\PatientNote;
use Carbon\Carbon;
use Code16\Sharp\Show\Fields\SharpShowTextField;
use Code16\Sharp\Show\Layout\ShowLayout;
use Code16\Sharp\Show\Layout\ShowLayoutColumn;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\Show\SharpShow;
use Code16\Sharp\Utils\Fields\FieldsContainer;

class EntityShow extends SharpShow
{
    public function buildShowFields(FieldsContainer $showFields): void
    {
        $showFields
        ->addField(
            SharpShowTextField::make('user_name')
                ->setLabel('Nazwisko pacjenta')
        )->addField(
            SharpShowTextField::make('subject')
                ->setLabel('Temat notatki')
        )->addField(
            SharpShowTextField::make('content')
                ->setLabel('Treść notatki')
        )->addField(
            SharpShowTextField::make('updated_at')
                ->setLabel('Ostatnia modyfikacja')
        );
    }

    public function buildShowLayout(ShowLayout $showLayout): void
    {
        $showLayout->addSection(
            'Notatka',
            function(ShowLayoutSection $section) {
                $section->addColumn(7, 
                    function(ShowLayoutColumn $column) {
                         $column->withSingleField('user_name')
                         ->withSingleField('subject')
                         ->withSingleField('updated_at');
                    }
                );
                $section->addColumn(5,
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField('content');
                    }
                );
            }
        );
    }

    public function find($id): array
    {
        $note = PatientNote::find($id);

        $this->setCustomTransformer('user_name', function($x, $patientNote){
            return $patientNote->user->name;
        });
        $this->setCustomTransformer('updated_at', function($x, $patientNote){
            return Carbon::parse($x)->format("d.m.Y H:i");
        });

        return $this->transform($note);
    }

    public function delete($id): void
    {
        PatientNote::findOrFail($id)->delete();
    }
}
