<?php

trait TSingleton {
    protected function __construct() {}
    protected function __clone() {}

    public static function instance($new = false)
    {
        static $instance = null;
        if (null === $instance || $new)
            $instance = new static;
        return $instance;
    }
}

class Application {
  use TSingleton;
}

$app1 = Application::instance();
$app2 = Application::instance();
$app3 = Application::instance(true);

var_dump(
  spl_object_hash($app1), // 0000000057e6e1370000000018414fb9
  spl_object_hash($app2), // 0000000057e6e1370000000018414fb9
  spl_object_hash($app3)  // 0000000057e6e1340000000018414fb9
);

var_dump(
  $app1 === $app2, // true
  $app1 === $app3  // false
);
