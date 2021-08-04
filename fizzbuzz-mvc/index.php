<?php

// Model and Controller instantiated in abstraction
abstract class Routes
{
    public $controller;
    public $model;

    public function __construct()
    {
        $this->controller = new Controller;
        $this->model = new Model;
    }
}

class Index extends Routes
{

    public $amount = 0;

    public function __construct()
    {

        parent::__construct();

        // create instance for index
        $this->view = new View('index');
        $this->amount = $this->model->getAmount();

        // Loop in route, so controller and view don't have separate loops 
        for ($count = 1; $count < $this->amount + 1; $count++) {
            $result = $this->controller->conditional($count);
            $this->view->display($result);
        }
    }
}

class Model
{
    private static $hiddenData = 100;

    public function getAmount()
    {
        return self::$hiddenData;
    }
}

class View
{

    public $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function display($value)
    {

        if (is_string($value)) {
            echo ucfirst($value) . "\n";
        } else {
            echo $value . "\n";
        }
    }
}

class Controller
{
    public function conditional($count)
    {
        $fizzbuzz = $count % 3 == 0 ? 'fizz' : '';
        $fizzbuzz .= $count % 5 == 0 ? 'buzz' : '';

        if (empty($fizzbuzz)) {
            return $count;
        } else {
            return $fizzbuzz;
        }
    }
}

// Index.php
new Index;
