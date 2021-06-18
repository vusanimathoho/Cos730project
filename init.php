<?php

session_name("ERM");
session_start();
ob_start();


ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

spl_autoload_register(array("Loader", "classLoader"));
require_once '../lib/common.php';
// defines database connection data
define('DB_TYPE', 'mysqli');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ersh_db');


function getDir() {
    $dirs = array();
    $dirs[] = "../lib/database/";
    $dirs[] = "../lib/";
    return $dirs;
}

class Loader {

    public static function classLoader($className) {

        if (!empty($className)) {
            foreach (getDir() as $path) {

                $classPath = $path . $className . ".php";

                if (file_exists($classPath)) {

                    require_once $classPath;
                    break;
                }
            }
        }
    }

}
