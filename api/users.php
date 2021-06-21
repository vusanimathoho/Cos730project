<?php
require_once './init.php';

$fun = [];

/**
 * POST 
 * 
 *  [
 *     username = {string} 
 *     password = {string} 
 *     type = {string}
 *  ]
 * 
 */
$fun["login"] = function () {
    $model = new Model("user");
    $data = $model->find()->only()->where(["email" => $_POST["email"], "password" => $_POST["password"]])->exec();
    if (empty($data)) {
        computeResult(["error" => true], "json");
    }
    $_SESSION["user"] = $data[0];
    computeResult(["error" => false], "json");
};

/**
 * POST 
 * 
 *  [
 *     username = {string} 
 *     password = {string} 
 *     email = {string}
 *  ]
 * 
 */
$fun["register"] = function () {
    $model = new Model("user");
    $data = $model->find()->only()->where(["email" => $_POST["email"], "password" => $_POST["password"]])->exec();
    if (!empty($data)) {
        computeResult(["error" => true], "json");
    }

    $model->insert()->only([
        "password" => $_POST["password"],
        "email" => $_POST["email"],
        "username" => $_POST["email"]
    ])->exec();

    computeResult(["error" => false], "json");
};

$fun[$_GET["fun"]]();
