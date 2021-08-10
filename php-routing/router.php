<?php

session_start();

class Route {

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

    static function getParams($query_arr) {
        
        $params = [];

        foreach ($query_arr as $query) {
            $keyValuePair = explode('=', $query);
            $params[$keyValuePair[0]] = $keyValuePair[1];
        }

        return $params;
    }

    static function parseUrl($route)
    {

        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        
        $request_path = parse_url($request_url, PHP_URL_PATH);
        $request_query = parse_url($request_url, PHP_URL_QUERY);
        // $request_fragment = parse_url($request_url, PHP_URL_FRAGMENT);
        $request_path_arr = explode('/', $request_path);
        $request_query_arr = explode('&', $request_query);

        $route_path = parse_url($route, PHP_URL_PATH);
        $route_query = parse_url($route, PHP_URL_QUERY);
        $route_path_arr = explode('/', $route_path);
        $route_query_arr = explode('&', $route_query);

        array_shift($request_path_arr);
        array_shift($route_path_arr);

        if ($request_path == '/' && $route_path == '/') {
            // mysql('/')
            exit();
        }

        if ((count($route_path_arr) != count($request_path_arr)) || (count($request_query_arr) != count($route_query_arr))) {
            return;
        }

        $id = Route::getId($route_path_arr, $request_path_arr);
        echo $id;
        
        $params = Route::getParams($request_query_arr);
        foreach ($params as $key => $value) {
            echo $key . '****' . $value;
        }
        
        if ($request_path_arr[0] == $route_path_arr[0]) {

            $table = $request_path_arr[0];
            // mysql($table, $id, $params)
            echo $table;
        }

        
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
