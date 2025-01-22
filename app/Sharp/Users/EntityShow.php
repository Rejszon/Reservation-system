<?php

namespace App\Sharp\Users;

use App\Models\User;
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
            SharpShowTextField::make('name')
                ->setLabel('Nazwisko pacjenta')
        )->addField(
            SharpShowTextField::make('email')
                ->setLabel('Email')
        )->addField(
            SharpShowTextField::make('created_at')
                ->setLabel('Data utworzenia')
        );
    }

    public function buildShowLayout(ShowLayout $showLayout): void
    {
        $showLayout->addSection(
            'Pacjent',
            function(ShowLayoutSection $section) {
                $section->addColumn(12, 
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField('name')
                        ->withSingleField('email')
                        ->withSingleField('created_at');
                    }
                );
            }
        );
    }

    public function find($id): array
    {
        $user = User::find($id);

        $this->setCustomTransformer('created_at', function($x, $user){
            return Carbon::parse($x)->format("d.m.Y H:i");
        });

        return $this->transform($user);
    }

    public function delete($id): void
    {
        User::findOrFail($id)->delete();
    }
}
