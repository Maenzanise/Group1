<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 13/04/2017
 * Time: 11:12
 */
session_start();
$access_level = $_COOKIE['access_level_cookie'];
displayAccesslevelInformation($accesslevel);

function displayAccesslevelInformation($accessLevel)
{
    if ($accessLevel == "student")
        echo "<p style = \"background-color:purple\">You are currently logged in as a student</p>";

    elseif ($accessLevel == "root"){
        echo "<p<p style = \"background-color: red\">You are currently logged in as admin</p>";
         echo "<p<p style = \"background-color: red\">You now have access to additional admin features</p>";

    }
}
header('Location: index.php');

?>