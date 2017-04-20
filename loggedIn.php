<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 13/04/2017
 * Time: 11:12
 */

session_start();

      $username = $_POST ['Username'];
      $password = $_POST ['Password'];

                if ($username && $password)

  {
    /*$password = md5($password);*/

    $connect = mysql_connect ("localhost", "root") or die (mysql_error());
    mysql_select_db("https://db2g.scm.azurewebsites.net/phpMyAdmin/") or die (mysql_error());

    $query = mysql_query ("select* from admin_users WHERE Username ='$username'");

    $numrows = mysql_num_rows($query);

    if ($numrows!=0)
    {
      while ($row =mysql_fetch_assoc ($query))
      {
            $dbusername = $row ['Username'];
            $dbpassword = $row ['Password'];
      }
      if ($username==$dbusername&&$password==$dbpassword)
      {
        echo "Welcome! <a href='index.php'>Click</a> here to enter the Admin Area.";
        $_SESSION['username']=$username;
      }
      else
          echo "Incorect Pasword";
    }
    else
        die ("That Admin does not exist");

   // echo $numrows;

  }
  else
      die("please click on the link to <a href='index.php'>Login</a>");


  ?>

session_start();
$access_level = $_COOKIE['access_level_cookie'];
displayAccesslevelInformation($access_levellevel);

function displayAccesslevelInformation($access_Level)
{
    if ($access_Level == "student")
        echo "<p style = \"background-color:purple\">You are currently logged in as a student</p>";

        elseif ($access_Level == "root"){
        echo "<p<p style = \"background-color: red\">You are currently logged in as admin</p>";
         echo "<p<p style = \"background-color: red\">You now have access to additional admin features</p>";

    }
}
header('Location: student_index.php');
ob_start();
require 'student_index.php';
$output = ob_get_clean();

?>