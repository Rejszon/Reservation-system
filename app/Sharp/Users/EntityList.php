<?php

namespace App\Sharp\Users;

use App\Models\User;
use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;

class EntityList extends SharpEntityList
{
    public function buildList(EntityListFieldsContainer $fields): void
    {
        $fields->addField(
            EntityListField::make('name')
                ->setLabel('Imię i nazwisko')
                ->setSortable()
                ->setWidth(3)
                ->setHtml()
        )->addField(
            EntityListField::make('email')
                ->setLabel('E-mail')
                ->setSortable()
                ->setWidth(3)
                ->setHtml()
        );
    }
    public function getListData(): array|Arrayable
    {
        $user = User::where('id', '!=', sharp_user()->id)->get();
        return $user;
    }
}
