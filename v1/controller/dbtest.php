<?php

require_once('db.php');
require_once('../model/response.php');

try{

    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
    $response = new Response();

    $response->sethttpStatusCode(200);
    $response->setSuccess(true);
    $response->setMessage("Database Connection success");
    $response->send();
}catch(PDOException $ex){
    $response = new Response();

    $response->sethttpStatusCode(500);
    $response->setSuccess(false);
    $response->setMessage("Database Connection error");
    $response->send();
    exit;
}