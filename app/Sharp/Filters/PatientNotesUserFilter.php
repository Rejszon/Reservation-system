<?php

namespace App\Sharp\Filters;

use Code16\Sharp\EntityList\Filters\EntityListSelectFilter;
use App\Models\User;

class PatientNotesUserFilter extends EntityListSelectFilter
{
    public function buildFilterConfig(): void
    {
        $this->configureKey('user_id')
            ->configureLabel('Pacjent')
            ->configureRetainInSession();
    }

    public function values(): array
    {
       return User::all()->pluck('name','id')->toArray();
    }
}
