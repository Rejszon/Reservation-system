<?php

return [
    'name' => 'Admin Panel',
    'custom_url_segment' => 'admin-panel',
    'auth' => [
        'check_handler' => \App\Sharp\SharpCheckHandler::class,
    ],
    'entities' => [
        'users' => \App\Sharp\Users\UsersEntity::class,
        'patient_notes' => \App\Sharp\PatientNotes\PatientNotesEntity::class,
    ],
    'menu' => \App\Sharp\Menu\Menu::class,
];
