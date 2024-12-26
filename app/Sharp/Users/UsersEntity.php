<?php

namespace App\Sharp\Users;

use Code16\Sharp\Utils\Entities\SharpEntity;

class UsersEntity extends SharpEntity
{
    protected ?string $list = EntityList::class;
    // protected ?string $show = EntityShow::class;
    // protected ?string $form = EntityForm::class;
    // protected ?string $policy = Policy::class;
    protected string $label = "Users";
}
