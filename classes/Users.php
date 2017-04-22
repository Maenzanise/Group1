<?php

class User {

    private $_connection;
    private $_db;
    public $error;

    public function __construct() {
        $this->_db = Db::getInstance();
        $this->_connection = $this->_db->getConnection();
    }


}
