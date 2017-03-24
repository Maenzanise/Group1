<?php
include("inc_global.php");// Establishing connection with our database
/**
 * Created by PhpStorm.
 * User: 1611403
 * Date: 23/03/2017
 * Time: 14:48
 */

 if(empty($_POST["username"]) || empty($_POST["password"]))
 {
     echo "Both fields are required.";
 }else
     $username = $_POST['username'];
     $password = $_POST['password'];
     $sql = "SELECT uid FROM users
             WHERE username=' $username' and password='$password'";
     $result = mysqli_query($db, $sql);
     if (mysqli_num_rows($result) == 1) {
         {
             header("location:index.html");
         }
     }

         // Redirecting To another Page
     else
         {
             {
             echo "Incorrect username or password.";
         }

}


?>


