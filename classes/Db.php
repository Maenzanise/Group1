<?php

class Db {

    private $_connection;
    private static $_instance;

    /**
     * 
     * @return 
     */
    
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
        // change the username and password to that set on your system {root - username} {dorespt: password}
        $this->_connection = new mysqli("localhost", "root", "Takson08", "college");

        if (mysqli_connect_error()) {
            trigger_error("Failed to connect to the database", E_USER_ERROR);
        }
    }

    /**
     * Returns a mysqli object
     * @return mysqli_object
     */
    public function getConnection() {
        return $this->_connection;
    }

    // TO PREVENT CLONING OF THE DATABASE OBJECT
    public function __clone() {}

}
