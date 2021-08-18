<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/Query.php");

session_start();

class Route {

    static public $queryModel;

    public function __construct()
    {
        self::$queryModel = new Query;
    }

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

        if (count($query_arr) <= 1) {
            return $params;
        }

        foreach ($query_arr as $query) {
            $keyValuePair = explode('=', $query);
            $params[$keyValuePair[0]] = $keyValuePair[1];
        }

        return $params;
    }

    static function parseUrl($route, $method)
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
            $results = self::$queryModel->noTableQuery();
            var_dump($results);
            exit();
        }

        if ((count($route_path_arr) != count($request_path_arr)) || (count($request_query_arr) != count($route_query_arr))) {
            return;
        }

        $id = Route::getId($route_path_arr, $request_path_arr);
        $params = Route::getParams($request_query_arr);


        
        if ($request_path_arr[0] == $route_path_arr[0] && $method == null) {
            
            $table = $request_path_arr[0];
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            
            $results = self::$queryModel->query($requestMethod, $table, $id, $params);
            var_dump($results);
        } elseif ($request_path_arr[0] == $route_path_arr[0]) {
            $result = $method->query();
            var_dump($result);
        }
    }

    function get($route, $method = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Route::parseUrl($route, $method);
        }
    }

    function post($route, $method = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Route::parseUrl($route, $method);
        }
    }

    function put($route, $method = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            Route::parseUrl($route, $method);
        }
    }

    function delete($route, $method = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            Route::parseUrl($route, $method);
        }
    }
}


