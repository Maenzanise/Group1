<?php

class User {

    private $_connection;
    private $_db;
    public $error;

    public function __construct() {
        $this->_db = Db::getInstance();
        $this->_connection = $this->_db->getConnection();
    }

    /**
     * Check users' login details in the database
     * @return boolean
     */
    public function check_login($email, $password) {
        $query = "SELECT count(*) AS number FROM users "
                . "WHERE `email` = '{$email}' "
                . "AND  `password` = '{$password}'";

        $handle = $this->_connection->query($query);
        if ((int) $handle->fetch_object()->number) {
            $this->email = $email;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Log user in after successfully checking their info
     * @return boolean
     */
    public function login() {
        $query = "SELECT id, account_type, active_state, email FROM `users` WHERE email = '$this->email'";

        $handle = $this->_connection->query($query);
        if ($handle) {
            $userDetails = $handle->fetch_object();

            $_SESSION['user_id'] = $userDetails->id;
            $_SESSION['account_type'] = $userDetails->account_type;
            $_SESSION['active_state'] = $userDetails->active_state;

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Destroys session data and unsets the session.
     * @return boolean
     */
    public function logout() {
        $_SESSION = array();
        session_destroy();

        return TRUE;
    }

    /**
     * This function gets user information
     * @return mysqli result object
     */
    private function getUserDetails($id) {
        $query = "SELECT * FROM users WHERE `id` = '$id'";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle->fetch_object();
        } else {
            return FALSE;
        }
    }

    public function getBasicDetails($id) {
        $query = "SELECT "
                . "icaz_reg_number, training_contract, training_period_a_start, training_period_a_end,"
                . "training_period_b_start, training_period_b_end, training_period_c_start, training_period_c_end"
                . " FROM users WHERE `id` = '$id'";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle->fetch_object();
        } else {
            return FALSE;
        }
    }

    /**
     * Gets the user's name
     * @return String
     */
    public function getName($id) {
        return $this->getUserDetails($id)->name;
    }

    /**
     * Gets the user's surname
     *
     * @return String
     */
    public function getSurname($id) {
        return $this->getUserDetails($id)->surname;
    }

    /**
     * Gets the user's full name
     *
     * @return String
     */
    public function getFullName($id) {
        $name = $this->getUserDetails($id)->first_name;
        $surname = $this->getUserDetails($id)->surname;
        return $name . " " . $surname;
    }

    /**
     * Get's the user's email
     * @return String
     */
    public function getEmail($id) {
        return $this->getUserDetails($id)->email;
    }

    /**
     * CREATES A STUDENT ACCOUNT
     * @param type $first_name
     * @param type $surname
     * @param type $account_type
     * @return boolean
     */
    public function createStudentAccount($first_name, $surname, $email, $password, $account_type) {
        $query = "INSERT INTO users (first_name, surname, email, password, account_type) VALUES "
                . "('$first_name', '$surname', '$email', '$password','$account_type')";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return TRUE;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }
    }

    public function createNewGroup($name, $course) {
        $query = "INSERT INTO groups (name, course) "
                . "VALUES "
                . "('$name', '$course')";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return TRUE;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }
    }

    public function addComment($user_id, $comment, $course_id){
        $query = "INSERT INTO comments (user_id, course_id, comment) "
                . "VALUES "
                . "('$user_id', '$course_id', '$comment')";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return TRUE;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }

    }

    public function addReply($comment_id, $reply, $user_id){
        $query = "INSERT INTO replies (comment_id, reply, user_id) "
                . "VALUES "
                . "('$comment_id', '$reply', '$user_id')";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return TRUE;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }

    }


    public function getMyComments($userId, $course_id){
        $query = "SELECT * FROM comments WHERE user_id = $userId AND course_id = $course_id";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }

    }

    public function getAllComments($course_id){
        $query = "SELECT * FROM comments WHERE course_id = $course_id";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }

    }

    public function getReplies($id){
        $query = "SELECT * FROM replies WHERE comment_id = $id";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }

    }


    public function getUserGroups(){
        $query = "SELECT * FROM groups";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }
    }

    public function getAllStudents(){
        $query = "SELECT * FROM users WHERE account_type = 1";

        $handle = $this->_connection->query($query);

        if ($handle) {
            return $handle;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }
    }

    public function addStudentToGroup($user_id, $group_id){
        $query = "INSERT INTO group_members (user_id, group_id) "
                . "VALUES "
                . "('$user_id', '$group_id')";


        $handle = $this->_connection->query($query);

        if ($handle) {
            return true;
        } else {
            $this->error = $this->_connection->error;
            return FALSE;
        }
    }
}
