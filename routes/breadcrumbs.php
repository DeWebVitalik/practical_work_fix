<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

//Files
Breadcrumbs::for('files', function ($trail) {
    $trail->parent('home');
    $trail->push('Files', route('files.index'));
});

//Links
Breadcrumbs::for('links', function ($trail) {
    $trail->parent('home');
    $trail->push('Links', route('links.index'));
});

//Add file
Breadcrumbs::for('file-add', function ($trail) {
    $trail->parent('home');
    $trail->push('Files', route('files.index'));
    $trail->push('Add file', route('files.create'));
});

//Show file
Breadcrumbs::for('file-show', function ($trail, $file) {
    $trail->parent('home');
    $trail->push('Files', route('files.index'));
    $trail->push($file->file_name);
});
