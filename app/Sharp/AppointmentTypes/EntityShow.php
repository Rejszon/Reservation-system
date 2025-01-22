<?php

namespace App\Sharp\AppointmentTypes;

use App\Models\AppointmentType;
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
            SharpShowTextField::make('title')
                ->setLabel('Tytuł')
        )->addField(
            SharpShowTextField::make('duration')
                ->setLabel('Czas trwania')
        )->addField(
            SharpShowTextField::make('price')
                ->setLabel('Cena')
        )->addField(
            SharpShowTextField::make('description')
                ->setLabel('Opis')
        );
    }

    public function buildShowLayout(ShowLayout $showLayout): void
    {
        $showLayout->addSection(
            'Usługa',
            function(ShowLayoutSection $section) {
                $section->addColumn(7, 
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField('title')
                        ->withSingleField('duration')
                        ->withSingleField('price');
                    }
                );
                $section->addColumn(5,
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField('description');
                    }
                );
            }
        );
    }

    public function find($id): array
    {
        $type = AppointmentType::find($id);

        $this->setCustomTransformer('price', function($x, $type){
            return $x." zł";
        });

        return $this->transform($type);
    }

    public function delete($id): void
    {
        AppointmentType::findOrFail($id)->delete();
    }
}
