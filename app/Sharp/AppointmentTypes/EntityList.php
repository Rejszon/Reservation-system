<?php

namespace App\Sharp\AppointmentTypes;

use App\Models\AppointmentType;
use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;

class EntityList extends SharpEntityList
{
    public function buildList(EntityListFieldsContainer $fields): void
    {
        $fields->addField(
            EntityListField::make('title')
                ->setLabel('Tytuł wizyty')
                ->setSortable()
                ->setWidth(2)
                ->setHtml()
        )->addField(
            EntityListField::make('description')
                ->setLabel('Opis usługi')
                ->setSortable()
                ->setWidth(3)
                ->setHtml()
        )->addField(
            EntityListField::make('duration')
                ->setLabel('Czas trwania')
                ->setSortable()
                ->setWidth(2)
                ->setHtml()
        )->addField(
            EntityListField::make('price')
                ->setLabel('Cena')
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
        $types = AppointmentType::query();
        
        $this->setCustomTransformer('price', function($x, $types){
            return $x." zł";
        });

        //display a maximum of the first 50 characters of the description
        $this->setCustomTransformer('description', function($x, $types){
            return strlen($types->description) > 50 
            ? substr($types->description, 0, 50) . '...' 
            : $types->description;
        });

        return $this->transform($types->get());
    }
}
