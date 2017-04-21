<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 21/04/2017
 * Time: 09:43


 CONNECT-DB.PHP
 Allows PHP to connect to your database
*/

 // Database Variables (edit with your own server information)
 $server = 'localhost';
 $user = 'root';
 $pass = '';
 $db = 'db2';

 // Connect to Database
 $connection = mysql_connect($server, $user, $pass)
 or die ("Could not connect to server ... \n" . mysql_error ());
 mysql_select_db($db)
 or die ("Could not connect to database ... \n" . mysql_error ());


?>