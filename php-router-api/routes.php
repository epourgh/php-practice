<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/Router.php");

$route = new Route;

class NewsQuery {
    function query() {
        return '';
    }
}

$route->get('/');

$route->get('/users');

$route->get('/user/:id');

$route->post('/user/add?name=:name&password=:password&email=:email');

$route->put('/user/:id?name=:name&password=:password&email=:email');

$route->delete('/user/:id');

$route->get('/news', new NewsQuery);