<?php

session_start();

class Route
{

    static function getId($route_arr, $path_arr)
    {
        $id = '';
        for ($i = 0; $i < count($route_arr); $i++) {
            $route_part = $route_arr[$i];
            if (preg_match("/:id/", $route_part)) {
                $route_part = ltrim($route_part, ':');
                $id = $path_arr[$i];
                $$route_part = $path_arr[$i];
            } else if ($route_arr[$i] != $path_arr[$i]) {
                return;
            }
        }

        return $id;
    }

    static function parseUrl($route)
    {

        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $path = parse_url($request_url, PHP_URL_PATH);
        $query = parse_url($request_url, PHP_URL_QUERY);
        $fragment = parse_url($request_url, PHP_URL_FRAGMENT);

        $route_arr = explode('/', $route);
        $path_arr = explode('/', $path);
        array_shift($route_arr);
        array_shift($path_arr);

        $id = Route::getId($route_arr, $path_arr);

        echo $id;
    }

    static function get($route)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Route::parseUrl($route);
        }
    }

    static function post($route)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Route::parseUrl($route);
        }
    }

    static function put($route)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            Route::parseUrl($route);
        }
    }

    static function delete($route)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            Route::parseUrl($route);
        }
    }
}
