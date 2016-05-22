<?php

Route::resource('notes', 'NotesController', [
    'parameters' => [
        'notes' => 'note'
    ]
]);
