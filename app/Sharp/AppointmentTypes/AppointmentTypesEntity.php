<?php

namespace App\Sharp\AppointmentTypes;

use Code16\Sharp\Utils\Entities\SharpEntity;

class AppointmentTypesEntity extends SharpEntity
{
    protected ?string $list = EntityList::class;
    protected ?string $show = EntityShow::class;
    protected ?string $form = EntityForm::class;
    // protected ?string $policy = Policy::class;
    protected string $label = "Appointment types";
}
