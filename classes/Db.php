<?php

class Db {

    private $_connection;
    private static $_instance;
    public $error;

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

        define('ENV_STR', 'MYSQLCONNSTR_localdb');
        $return = array('result' => false);
        if (isset($_SERVER[ENV_STR])) {
            $connectStr = $_SERVER[ENV_STR];
            $return['connection'] = array(
                'host' => preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $connectStr),
                'database' => preg_replace("/^.*Database=(.+?);.*$/", "\\1", $connectStr),
                'user' => preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $connectStr),
                'password' => preg_replace("/^.*Password=(.+?)$/", "\\1", $connectStr)
            );
            $return['result'] = true;
        }


        $data = $return['connection'];
        $host = $data['host'];
        $database = $data['database'];
        $user = $data['user'];
        $password = $data['password'];

        $this->_connection = new mysqli($host, $user, $password, $database);

        if (mysqli_connect_error()) {
//            trigger_error("Failed to connect to the database", E_USER_ERROR);
            $this->_connection->error = $this->_connection->error;
//            die("unable to connect to the database : " . $this->_connection->error);
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
