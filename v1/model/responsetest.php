<?php

require_once('response.php');

$response = new Response();

$response->setSuccess(true);
$response->sethttpStatusCode('200');
$response->setMessage("Test Success");
$response->send();