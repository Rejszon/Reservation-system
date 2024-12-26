<?php

namespace App\Sharp\PatientNotes;

use App\Sharp\Filters\PatientNotesUserFilter;
use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Log;
use App\Models\PatientNote;

class EntityList extends SharpEntityList
{
    public function buildList(EntityListFieldsContainer $fields): void
    {
        $fields->addField(
            EntityListField::make('user')
                ->setLabel('Pacjent')
                ->setSortable()
                ->setWidth(3)
                ->setHtml()
        )->addField(
            EntityListField::make('subject')
                ->setLabel('Temat')
                ->setSortable()
                ->setWidth(3)
                ->setHtml()
        )->addField(
            EntityListField::make('content')
                ->setLabel('Treść')
                ->setSortable()
                ->setWidth(3)
                ->setHtml()
        );
    }

    function getFilters(): ?array
    {
        return [
            PatientNotesUserFilter::class,
        ];
    }
    
    public function getListData(): array|Arrayable
    {
        $notes = PatientNote::query();

        if($user = $this->queryParams->filterFor(PatientNotesUserFilter::class)) {
            $notes->where('user_id', $user);
        }
        
        $this->setCustomTransformer('user', function($x, $patientNote){
            return $patientNote->user->name;
        });

        //display a maximum of the first 50 characters of the content
        $this->setCustomTransformer('content', function($x, $patientNote){
            return strlen($patientNote->content) > 50 
            ? substr($patientNote->content, 0, 50) . '...' 
            : $patientNote->content;
        });

        return $this->transform($notes->get());
    }
}
