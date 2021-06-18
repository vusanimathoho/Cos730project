<?php

require_once './init.php';
$fun = [];

/**
 * POST 
 * 
 *  [
 *      contact_number = {string}
 *      liter = {number}
 *      
 *  ]
 * 
 */
$fun["make-request"] = function () {

    $model = new Model("requests");
    $model->insert()->only([
        "StationID" => $_POST["station_id"],
        "UserID" => $_SESSION["user"]->UserID,
        "contact_number" => $_POST["cell"],
        "litre" => $_POST["litre"]
    ])->exec();

    computeResult(["error" => false], "json");
};

$fun["get-requests"] = function () {
    $model = new Model("requests");
    $data = $model->find()->only()->exec();

    computeResult(["error" => false, "data" => $data], "json");
};

/**
 * POST 
 * 
 *  [
 * 
 *      petrol_cost = {number}
 *      delivery_fee = {number}
 *      request_id = {number}
 *      
 *  ]
 * 
 */
$fun["make-quote"] = function () {
    $model = new Model("quote");
    $model->insert()->only([
        "RequestID" => $_POST["request_id"],
        "UserID" => $_SESSION["user"]->UserID,
        "litre_fee" => $_POST["petrol_cost"],
        "delivery_fee" => $_POST["delivery_fee"]
    ])->exec();

    computeResult(["error" => false], "json");
};

/**
 * POST 
 * 
 *  [
 *      
 *      
 *  ]
 * 
 */
$fun["get-quote"] = function () {
    $model = new Model("requests");
    $data = $model->find()->only(["*","quote.UserID as quote_user_id"])->joinLeft(["quote"=>"RequestID"])->where(["requests.UserID" => $_SESSION["user"]->UserID])->exec();

    computeResult(["error" => false, "data" => $data], "json");
};

/**
 * POST 
 * 
 *  [
 *      quote_id = {number}
 *      
 *  ]
 * 
 */
$fun["accept-quote"] = function () {
    $model = new Model("quote");
    $model->update()->only([
        "isAccepted" => 1,
    ])->where(["QuoteID" => $_POST["quote_id"],])->exec();

    computeResult(["error" => false], "json");
};

/**
 * POST 
 * 
 *  [
 *      user_id = {number}
 *  ]
 * 
 */
$fun["get-invoice"] = function () {
    $model = new Model("requests");
    $data = $model->find()->only(["*","quote.UserID as quote_user_id"])->joinLeft(["quote"=>"RequestID"])->where(["quote.UserID" => $_SESSION["user"]->UserID,"isAccepted"=>1])->exec();

    computeResult(["error" => false, "data" => $data], "json");
};

$fun[$_GET["fun"]]();
