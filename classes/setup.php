<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 22/04/2017
 * Time: 14:00
 */

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

// Name of the file
$filename = 'database.sql';
// MySQL host
$mysql_host = $host;
// MySQL username
$mysql_username = $user;
// MySQL password
$mysql_password = $password;
// Database name
$mysql_database = $database;

// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

// Add this line to the current segment
    $templine .= $line;
// If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query
        mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
    }
}
echo "Tables imported successfully";