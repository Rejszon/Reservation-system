<?php

namespace App\Sharp\Appointments;

use App\Models\Appointment;
use Carbon\Carbon;
use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;

class EntityList extends SharpEntityList
{
    public function buildList(EntityListFieldsContainer $fields): void
    {
        $fields->addField(
            EntityListField::make('client')
                ->setLabel('Pacjent')
                ->setSortable()
                ->setWidth(2)
                ->setHtml()
        )->addField(
            EntityListField::make('start_time')
                ->setLabel('Termin')
                ->setSortable()
                ->setWidth(2)
                ->setHtml()
        )->addField(
            EntityListField::make('duration')
                ->setLabel('Czas trwania')
                ->setSortable()
                ->setWidth(1)
                ->setHtml()
        )->addField(
            EntityListField::make('comments')
                ->setLabel('Komentarz')
                ->setWidth(3)
                ->setHtml()
        )->addField(
            EntityListField::make('appointment_type')
                ->setLabel('Typ wizyty')
                ->setSortable()
                ->setWidth(2)
                ->setHtml()
        );
    }

    // function getFilters(): ?array
    // {
    //     return [
            
    //     ];
    // }
    
    public function getListData(): array|Arrayable
    {
        $appointments = Appointment::query();
        
        $this->setCustomTransformer('client', function($x, $appointment){
            return $appointment->client->name;
        });

        $this->setCustomTransformer('appointment_type', function($x, $appointment){
            return $appointment->type->title;
        });

        $this->setCustomTransformer('start_time', function($x, $appointment){
            return Carbon::parse($x)->format("d.m.Y H:i");
        });

        $this->setCustomTransformer('duration', function($x, $appointment){
            return $appointment->type->duration;
        });

        //display a maximum of the first 50 characters of the comment
        $this->setCustomTransformer('comments', function($x, $appointment){
            return strlen($appointment->comments) > 50 
            ? substr($appointment->comments, 0, 50) . '...' 
            : $appointment->comments;
        });

        return $this->transform($appointments->get());
    }
}
