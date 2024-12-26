<?php

namespace App\Sharp\Menu;

use Code16\Sharp\Utils\Menu\SharpMenu;

class Menu extends SharpMenu
{
    public function build(): self
    {
        return $this
            ->addEntityLink('users', 'Użytkownicy', 'fa-page')
            ->addEntityLink('patient_notes', 'Uwagi dla pacjentów', 'fa-page');
    }
}