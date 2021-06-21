<?php
require_once './init.php';
/**
 * POST 
 * 
 *  [
 *      
 *      log = {float}     
 *      lag = {float}    
 * 
 *  ]
 * 
 */
$fun["get-statons"] = function () {
    $model = new Model("stations");
    $data = $model->find()->only()->exec();

    computeResult(["error" => false, "data" => $data], "json");
};
