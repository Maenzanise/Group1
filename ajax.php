<?php

require 'core/init.php';
$user = new User;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $students = $user->getStudentsInGroup(filter_input(0, "id"));

    $users = array();

    if ($students->num_rows > 0) {

        $users['success'] = true;

        while ($row = $students->fetch_assoc()) {
            $users['data'][] = $row;
        }

        $users['message'] = "successfully retrieved data";
    } else {
        $users['success'] = false;
        $users['message'] = $user->error;
    }

    $return = json_encode($users);

    echo $return;
}

