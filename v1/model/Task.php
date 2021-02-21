<?php

class TaskException extends Exception{
}

class Task{

    private $_id;
    private $_title;
    private $_description;
    private $_deadline;
    private $_completed;

    public function __construct($id, $title, $description, $deadline, $completed){
        $this->setID($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setDeadline($deadline);
        $this->setCompleted($completed);
    }

    public function getID(){
        return $this->_id;
    }

    public function getTitle(){
        return $this->_title;
    }

    public function getDescription(){
        return $this->_description;
    }

    public function getDeadline(){
        return $this->_deadline;
    }

    public function getCompleted(){
        return $this->_completed;
    }

    public function setID($id){
        if($id == null){
            throw new TaskException("Task ID error");
        }
        $this->_id = $id;
        
    }

    public function setTitle($title){
        if($title == null){
            throw new TaskException("Task title error");
        }
        $this->_title = $title;
    }

    public function setDescription($description){
        if($description == null){
            throw new TaskException("Task description error");
        }
        $this->_description = $description;
    }

    public function setDeadline($deadline){
        $this->_deadline = $deadline;
    }

    public function setCompleted($completed){
        if($completed !== 'N' && $completed !== 'Y'){
            throw new TaskException("Task completed must be Y or N");
        }
        $this->_completed = $completed;
    }

    public function returnTaskAsArray(){
        $taski = array();
        $taski['id'] = $this->getID();
        $taski['title'] = $this->getTitle();
        $taski['description'] = $this->getDescription();
        $taski['deadline'] = $this->getDeadline();
        $taski['completed'] = $this->getCompleted();

        return $taski;
    }


}