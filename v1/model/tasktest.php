<?php

require_once('task.php');

try{

    $task = new Task(12,"title here","description here","deadline here", "Y");
    header('Content-type: application/json;charset=UTF-8');
    echo json_encode($task->returnTaskAsArray());

}catch(TaskException $ex){
    echo "Error: ". $ex->getMessage();
}