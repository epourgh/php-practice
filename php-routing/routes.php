<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

Route::get('/');

Route::get('/user/:id');

Route::get('/user/:id?name=:name&password=:password&email=:email');
