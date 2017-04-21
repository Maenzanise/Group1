<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 12/04/2017
 * Time: 12:54
 */

require_once('includes/inc_global.php');

$mod = '';
if (isset($_SERVER['PATH_INFO']) && (strlen($_SERVER['PATH_INFO']) > 0)) {
  $mod = substr($_SERVER['PATH_INFO'], 1);
} else if (isset($_SERVER['QUERY_STRING'])) {
  $mod = $_SERVER['QUERY_STRING'];
}

if ($mod && in_array($mod, $INSTALLED_MODS))$INSTALLED_MODS = array();   {
  if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    include_once("mod/{$mod}/index.php");
  } else {
    header('Location: ' . define('APP__WWW', 'https://webpa.moodle-test.ucl.ac.uk/')  . "/mod/{$mod}/");
  }

  if ($_user->is_admin()) {
    header('Location: ' . define(('APP__WWW' .'https://webpa.moodle-test.ucl.ac.uk/'). '/admin/'));
  } else if ($_user->is_tutor()) {
    header('Location: ' . define('APP__WWW' .'https://webpa.moodle-test.ucl.ac.uk/') . '/tutors/');
  } else {
    header('Location: ' . define('APP__WWW' .'https://webpa.moodle-test.ucl.ac.uk/') . '/students/');
    {

      }
  }

  header('Location: ' . APP__WWW . '/checklogin.php');
}

exit;

?>



