<?php

require_once('db.php');
require_once('../model/Task.php');
require_once('../model/response.php');

try{

    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
}catch(PDOException $ex){
    error_log("Connection error -".$ex,0);
    $response = new Response();
    $response->sethttpStatusCode(500);
    $response->setStatus(false);
    $response->setMessage("Database Connection error");
    $response->send();
    exit();
}

if(array_key_exists("taskid",$_GET)){

    $taskid = $_GET['taskid'];
    
    if($taskid == '' || !is_numeric($taskid)){
        $response = new Response();
        $response->sethttpStatusCode(400);
        $response->setSuccess(false);
        $response->setMessage("Task ID not correct");
        $response->send();
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        try{

            $query = $readDB->prepare('select id, title, description, DATE_FORMAT( deadline, "%d/%m/%y %H:%i")deadline, completed from tbltasks where id = :taskid');
            $query->bindParam(':taskid', $taskid, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();
            if($rowCount === 0){
                $response = new Response();
                $response->sethttpStatusCode(404);
                $response->setSuccess(false);
                $response->setMessage("Task not found");
                $response->send();
                exit();
            }

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['completed']);
                $taskArray[] = $task->returnTaskAsArray();
            }

            $returnData = array();
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;

            $response = new Response();
            $response->sethttpStatusCode(200);
            $response->setSuccess(true);
            $response->setMessage("Success");
            $response->toCache(false);
            $response->setData($returnData);
            $response->send();
            exit();

        }catch(TaskException $ex){
            $response = new Response();
            $response->sethttpStatusCode(500);
            $response->setSuccess(false);
            $response->setMessage($ex->getMessage);
            $response->send();
            exit();
        }catch(PDOException $ex){
            error_log("Database query error -".$ex,0);
            $response = new Response();
            $response->sethttpStatusCode(500);
            $response->setSuccess(false);
            $response->setMessage("Failed to get task");
            $response->send();
            exit();
        }

    }else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

        try{
            
            $query = $writeDB->prepare('delete from tbltasks where id=:taskid');
            $query->bindParam(':taskid',$taskid,PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();

            if($rowCount === 0){
                $response = new Response();
                $response->sethttpStatusCode(404);
                $response->setSuccess(false);
                $response->setMessage("Task not found");
                $response->send();
                exit();
            }

            $response = new Response();
            $response->sethttpStatusCode(200);
            $response->setSuccess(true);
            $response->setMessage("Deleted sucessfully");
            $response->send();
            exit();

        }catch(PDOException $ex){
            $response = new Response();
            $response->sethttpStatusCode(500);
            $response->setSuccess(false);
            $response->setMessage("Failed to delete task");
            $response->send();
            exit();
        }

    }else if($_SERVER['REQUEST_METHOD'] === 'PATCH'){

    }else{
        $response = new Response();
        $response->sethttpStatusCode(405);
        $response->setSuccess(false);
        $response->setMessage("Request method not allowed");
        $response->send();
        exit();
    }
}