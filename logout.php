<?php
require 'core/init.php';

$user = new User;
if($user->logout())
    header("location: login.php");