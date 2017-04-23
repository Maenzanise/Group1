<?php
require 'core/init.php';
// Check if the user has the rights

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}elseif($_SESSION['account_type'] != '0'){
    header("location: courses.php");
}

$user = new User();

if(filter_input(1, "action")){

    $id = filter_input(1, "id", FILTER_SANITIZE_NUMBER_INT);

    if(filter_input(1, "action") == "demote"){
        if($user->makeStudent($id)){
            header("location: students.php?scc=demote");
        }else{
            echo 'we are here';
        }
    }

    if(filter_input(1, "action") == "elevate"){
        if($user->makeAdmin($id)){
            header("location: students.php?scc=elevate");
        }
    }

    if(filter_input(1, "action") == "delete"){
        if($user->deleteUser($id)){
            header("location: students.php?scc=delete");
        }else{
            echo 'we are here';
            var_dump($id);
        }
    }
}



