<?php

namespace App\Sharp\Appointments;

use App\Models\Appointment;
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
            SharpShowTextField::make('client')
                ->setLabel('Nazwisko pacjenta')
        )->addField(
            SharpShowTextField::make('start_time')
                ->setLabel('Termin')
        )->addField(
            SharpShowTextField::make('duration')
                ->setLabel('Czas trwania')
        )->addField(
            SharpShowTextField::make('comments')
                ->setLabel('Komentarz')
        )->addField(
            SharpShowTextField::make('special_price')
                ->setLabel('Specjalna cena')
        )->addField(
            SharpShowTextField::make('appointment_type')
                ->setLabel('Typ wizyty')
        );
    }

    public function buildShowLayout(ShowLayout $showLayout): void
    {
        $showLayout->addSection(
            'Wizyta',
            function(ShowLayoutSection $section) {
                $section->addColumn(7, 
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField('client')
                        ->withSingleField('start_time')
                        ->withSingleField('duration')
                        ->withSingleField('special_price')
                        ->withSingleField('appointment_type');
                    }
                );
                $section->addColumn(5,
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField('comments');
                    }
                );
            }
        );
    }

    public function find($id): array
    {
        $appointment = Appointment::find($id);

        $this->setCustomTransformer('client', function($x, $appointment){
            return $appointment->client->name;
        });
        $this->setCustomTransformer('start_time', function($x, $appointment){
            return Carbon::parse($x)->format("d.m.Y H:i");
        });
        $this->setCustomTransformer('appointment_type', function($x, $appointment){
            return $appointment->type->title;
        });

        $this->setCustomTransformer('duration', function($x, $appointment){
            return $appointment->type->duration;
        });

        $this->setCustomTransformer('special_price', function($x, $appointment){
            return $x." zł";
        });

        return $this->transform($appointment);
    }

    public function delete($id): void
    {
        Appointment::findOrFail($id)->delete();
    }
}
