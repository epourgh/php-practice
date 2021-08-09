<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

Route::get('/');

Route::get('/user/:id');
