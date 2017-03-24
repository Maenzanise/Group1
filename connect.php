<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 24/03/2017
 * Time: 20:53
 */
define(' DB_SERVER', '
http://db2g.azurewebsites.net');
define(' DB_USERNAME', 'name1');
define(' DB_PASSWORD', 'pass1');
define(' DB_DATABASE', 'test1');
$db = mysqli_connect(DB_SERVER , DB_USERNAME , DB_PASSWORD , DB_DATABASE);
?>