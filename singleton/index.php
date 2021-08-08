<?php

final class Singleton
{

    private static $instance;
    private static $num;

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }

    public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Singleton();
        }

        return self::$instance;
    }

    public static function setNum()
    {
        self::$num = rand(1, 10);
    }

    public static function getNum()
    {
        return self::$num;
    }
}

Singleton::setNum();
$instance = Singleton::getInstance();
$numVal = $instance->getNum();
echo "Instance 1: " . $numVal . "\n";

$instance2 = Singleton::getInstance();
$numVal2 = $instance2->getNum();
echo "Instance 2: " . $numVal2 . "\n";

$instance3 = Singleton::getInstance();
$numVal2 = $instance3->getNum();
echo "Instance 3: " . $numVal2 . "\n";
