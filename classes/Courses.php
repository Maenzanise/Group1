<?php
class Courses {
    private $_connection;
    private $_db;
    public $error;
    public $insertId;

    public function __construct() {
        $this->_db = Db::getInstance();
        $this->_connection = $this->_db->getConnection();
    }
    


    public function addNewCourse($name, $description){
        $query = "INSERT INTO courses (name, notes) "
                . "VALUES "
                . "('$name', '$description')";
        
        $handle = $this->_connection->query($query);
        
        if($handle){
            // This means we were able to save
            $this->insertId = $this->_connection->insert_id;
            return TRUE;
        }else{
            $this->error = $this->_connection->error;
            return FALSE;
        }
    }
    
    public function addSupportingDocs($courseId, $name, $path){
        $query = "INSERT INTO documents (course_id, name, path) "
                . "VALUES ('$courseId', '$name', '$path')";
        
        $handle = $this->_connection->query($query);
        
        if($handle){
            // This means we were able to save
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function getAllCourses(){
        $query = "SELECT * FROM courses";
        
        $handle = $this->_connection->query($query);
        
        if($handle){
            // This means we were able to save
            return $handle;
        }else{
            return FALSE;
        }
    }
    
    public function getCourseDetails($id){
        $query = "SELECT * FROM courses WHERE id = $id";
        
        $handle = $this->_connection->query($query);
        
        if($handle){
            // This means we were able to save
            return $handle;
        }else{
            return FALSE;
        }
    }
    
    public function getCourseDocuments($course_id){
        $query = "SELECT * FROM documents WHERE course_id = $course_id";
        
        $handle = $this->_connection->query($query);
        
        if($handle){
            // This means we were able to save
            return $handle;
        }else{
            return FALSE;
        }
    }
}
