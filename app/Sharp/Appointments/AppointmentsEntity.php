<?php

namespace App\Sharp\Appointments;

use Code16\Sharp\Utils\Entities\SharpEntity;

class AppointmentsEntity extends SharpEntity
{
    protected ?string $list = EntityList::class;
    protected ?string $show = EntityShow::class;
    protected ?string $form = EntityForm::class;
    // protected ?string $policy = Policy::class;
    protected string $label = "Appointments";
}
