<?php


require_once  '../lib/init.php';

$routes = new vueRoute();

$routes->addRoute("/", "login","pages/");
$routes->addRoute("/login", "login","pages/");
$routes->addRoute("/login/:id", "login2","pages/");
$routes->addRoute("/register", "register","pages/");
$routes->addRoute("/attendee", "attendee","pages/");
$routes->addRoute("/attendent", "attendent","pages/");
$routes->addRoute("/map", "map","pages/");
$routes->addRoute("/my-requests", "requests","pages/");
$routes->addRoute("/requests", "requests","pages/");
$routes->addRoute("/accept-quote/:id", "acceptQuote","pages/");
$routes->addRoute("/quotations", "quotations","pages/");
$routes->addRoute("/create-quote/:id", "createQuote","pages/");
$routes->addRoute("/my-invoices", "myInvoice","pages/");
$routes->addRoute("/my-quotes", "myQuote","pages/");

$routes->exec($_GET["type"]);
