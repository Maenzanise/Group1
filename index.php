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

if ($mod && in_array($mod, $INSTALLED_MODS)) {
  if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    include_once("mod/{$mod}/index.php");
  } else {
    header('Location: ' . APP__WWW . "/mod/{$mod}/");
  }
} else if ($_user) {
  if ($_user->is_admin()) {
    header('Location: ' . APP__WWW . '/admin/');
  } else if ($_user->is_tutor()) {
    header('Location: ' . APP__WWW . '/tutors/');
  } else {
    header('Location: ' . APP__WWW . '/students/');
  }
} else {
  header('Location: ' . APP__WWW . '/login.php');
}

exit;

?>




LOGIN.PHP

<?php
/**
 *
 * Login page
 *
 *
 * @copyright 2017 Robert Gordon University
 * @license http://www.rgu.org/licenses/gpl.txt
 * @version 5.1.1.0
 *
 * + Added a link to /accounts/reset.php ('Forgotten your password?')
 * made by Terence Maenzanise [t.p.maenzanise@rgu.ac.uk] as of 15/03/17
 *
 */

require_once("includes/inc_global.php");

// --------------------------------------------------------------------------------
// Process GET/POST

$msg = fetch_GET('msg', null);

switch ($msg) {
  case 'connfailed' :
        $message_class = 'warning';
        $message = 'A connection to the authentication server could not be established.<br />Please try again later.';
        break;
  // --------------------
  case 'denied' :
        $message_class = 'warning';
        $message = 'You attempted to access a restricted page.<br />It may be that your session has timed out so please re-enter your details.';
        break;
  // --------------------
  case 'no access' :
        $message_class = 'warning';
        $message = 'Your account has been disabled.<br />Please contact support if you do not think this should be the case.';
        break;
  // --------------------
  case 'invalid' :
        $message_class = 'warning';
        $message = 'Your username and password were rejected.<br />Please check your details and try again.';
        break;
  // --------------------
  case 'cookies' :
        $message_class = 'warning';
        $message = 'Unable to connect to ' . APP__NAME . '; please ensure that your browser is not blocking third-party cookies';
        break;
  // --------------------
  case 'logout' :
        $message_class = 'info';
        $message = 'You have logged out.<br />If you wish to log back in, please re-enter your details.';
        break;
  // --------------------
  default :
        $message_class = 'info';
        $message = 'To start using WebPA you have to log in.';
        break;
}

// --------------------------------------------------------------------------------
// Begin Page

$UI->page_title = 'Robert Gordon Online Assessment Login';
$UI->menu_selected = '';
$UI->help_link = '?q=node/26';
$UI->breadcrumbs = array  (
  'login page'  => null ,
);


$UI->head();
?>
<style type="text/css">
<!--

p.warning { color: #f00; }
p.info { color: #000; }

-->
</style>
<script language="JavaScript" type="text/javascript">
<!--

  var username_focussed = false;
  var password_focussed = false;

  function username_focus() {
    if ( (!username_focussed) && (!password_focussed) ) { document.getElementById('username').focus(); }
  }

//-->
</script>
<?php
$UI->body('onload="username_focus();"');
$UI->content_start();
?>


<?php echo("<p class=\"$message_class\">$message</p>"); ?>

<div class="content_box">

  <p>Please enter your details below:</p>

  <form action="login_check.php" method="post" name="login_form" style="margin-bottom: 2em;">
  <div style="width: 300px;">
    <table class="form" cellpadding="2" cellspacing="1" width="100%">
    <tr>
      <th><label for="username">Username</label></th>
      <td><input type="text" name="username" id="username" maxlength="30" size="10" value="" onfocus="username_focussed=true" onblur="username_focussed=false" /></td>
    </tr>
    <tr>
      <th><label for="password">Password</label></th>
      <td><input type="password" name="password" id="password" maxlength="16" size="10" value="" onfocus="password_focussed=true" onblur="password_focussed=false" /></td>
    </tr>
    </table>

    <div class="form_button_bar">
      <input class="safe_button" type="submit" name="submit" value="login" />
    </div>
  </div>
  </form>
  <p><strong><a href="accounts/reset.php">Forgotten your password?</a></strong></p>
  <p>This site requires cookies - If you have trouble logging in, please check your cookie settings.</p>

</div>

<?php
$UI->content_end(false);







require_once("./includes/inc_global.php");

// --------------------------------------------------------------------------------
// Process Get/Post

$username = (string) fetch_POST('username');
$password = (string) fetch_POST('password');

// Sanitize the username/password data
$username = substr($username,0,255);
$password = substr($password,0,255);

$msg ='';

// --------------------------------------------------------------------------------
// Attempt Login

$auth_success = false;

if ( ($username) && ($password) ) {

  $authenticated = FALSE;

  // Authenticate...
  require_once(DOC__ROOT . 'includes/classes/class_authenticator.php');
  for ($i = 0; $i < count($LOGIN_AUTHENTICATORS); $i++) {
    $classname = $LOGIN_AUTHENTICATORS[$i];
    require_once(DOC__ROOT . 'includes/classes/class_' . strtolower($classname) . '_authenticator.php');
    $classname .= "Authenticator";
    $_auth = new $classname($username, $password);
    if ($_auth->authenticate()) {
      $authenticated = TRUE;
      break;
    }
  }

  if (!$authenticated) {

    $msg = 'invalid';

    //but just to be sure check for an authorisation failed message
    $auth_failed = $_auth->get_error();

    if(strlen($auth_failed) > 0){
      $msg = $auth_failed;
    }

  } else if ($_auth->is_disabled()) {

    $msg = 'no access';

  } else {

    $_SESSION = array();
    session_destroy();
    session_name(SESSION_NAME);
    session_start();

    // Save session data
    $_SESSION['_user_id'] = $_auth->user_id;
    $_SESSION['_user_source_id'] = $_auth->source_id;
    $_SESSION['_user_type'] = $_auth->user_type;
    $_SESSION['_source_id'] = $_auth->source_id;
    $_SESSION['_module_id'] = $_auth->module_id;
    $_SESSION['_user_context_id'] = $_auth->module_code;

    logEvent('Login');
    logEvent('Enter module', $_auth->module_id);

    header('Location: ' . APP__WWW . "/index.php?id={$_user_id}"); // This doesn't log them in, the user_id just shows as a debug check
    exit;

  }

} else {

  $msg = '';

}

header('Location: ' . APP__WWW . "/login.php?msg={$msg}");
exit;

?>



LOGOUT.PHP

<?php
/**
 *
 * Logout page
 *
 *
 * @copyright 2017 Robert Gordon University
 * @license http://www.rgu.org/licenses/gpl.txt
 * @version 1.0.0.0
 *
 */

require_once("includes/inc_global.php");

if (isset($_SESSION['_user_id'])) {
  logEvent('Logout');
}

$old_session = $_SESSION;
$_SESSION = array();
session_destroy();

if (isset($old_session['logout_url'])) {
  $url = $old_session['logout_url'];
  if ($_SERVER['QUERY_STRING']) {
    if (strpos($url, '?') === FALSE) {
      $url .= '?';
    } else {
      $url .= '&';
    }
    $url .= $_SERVER['QUERY_STRING'];
  }
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]);
  }
} else {
  $msg = (fetch_GET('msg',null)) ? fetch_GET('msg',null) : 'logout' ;
  $url = "login.php?msg=$msg";
  session_start();
  if (isset($old_session['branding_logo'])) {
    $_SESSION['branding_logo'] = $old_session['branding_logo'];
  }
  if (isset($old_session['branding_logo.width'])) {
    $_SESSION['branding_logo.width'] = $old_session['branding_logo.width'];
  }
  if (isset($old_session['branding_logo.height'])) {
    $_SESSION['branding_logo.height'] = $old_session['branding_logo.height'];
  }
  if (isset($old_session['branding_name'])) {
    $_SESSION['branding_name'] = $old_session['branding_name'];
  }
  if (isset($old_session['branding_css'])) {
    $_SESSION['branding_css'] = $old_session['branding_css'];
  }

}

header("Location: $url");

?>


COOKIE.PHP

<?php
/**
 *
 * INDEX - Main page
 *
 * @copyright 2017 Robert Gordon University
 * @license http://www.rgu.org/licenses/gpl.txt
 * @version 1.0.0.0
 *
 */

require_once('includes/inc_global.php');

$url = '';
if (isset($_GET['url'])) {
  $url = $_GET['url'];
}

if ($_user) {
  $id = '';
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }
  header('Location: ' . APP__WWW . '/index.php?id=' . $id);
} else if ($url) {
  if (strpos($url, '?') === FALSE) {
    $url .= '?';
  } else {
    $url .= '&';
  }
  header('Location: ' . $url . 'lti_errormsg=' . urlencode('Unable to connect to ' . APP__NAME . '; please ensure that your browser is not blocking third-party cookies'));
} else {
  header('Location: ' . APP__WWW . '/login.php?msg=cookies');
}

exit;

?>

MODULE.PHP

<?php
/**
 *
 * Change module page
 *
 *
 * @copyright 2017 Robert Gordon University
 * @license http://www.rgu.org/licenses/gpl.txt
 * @version 1.0.0.0
 *
 */

require_once("includes/inc_global.php");

if (($_source_id != '') && !$_user->is_admin()) {
  header('Location:'. APP__WWW .'/logout.php?msg=denied');
  exit;
}

$module_id = fetch_POST('module_id');

if ($module_id) {

  // Update last module
  $sql_last_module = 'UPDATE ' . APP__DB_TABLE_PREFIX . "user SET last_module_id = '{$module_id}' WHERE user_id = '{$_user_id}'";
  $DB->execute($sql_last_module);

  // Update session
  $sql_module = 'SELECT module_code FROM ' . APP__DB_TABLE_PREFIX . "module WHERE module_id = {$module_id}";
  $module = $DB->fetch_row($sql_module);
  $_SESSION['_module_id'] = $module_id;
  $_SESSION['_user_context_id'] = $module['module_code'];

  logEvent('Leave module', $_module_id);
  logEvent('Enter module', $module_id);

  header('Location: ' . APP__WWW . "/");
  exit;

}

//set the page information
$UI->page_title = 'Change Module';
$UI->menu_selected = 'change module';
$UI->breadcrumbs = array ('home' => './', 'change source' => null);
$UI->help_link = '?q=node/237';
$UI->head();
$UI->body();
$UI->content_start();

//build the content to be written to the screen

$page_intro = 'Use this page to change the currently selected module.';

?>

<p><?php echo $page_intro; ?></p>

<form action="" method="post" name="select_module">
<div class="content_box">
<table class="option_list" style="width: 100%;">
<?php
  //get the modules associated with the user being edited
  if ($_user->is_admin()) {
    $modules = $CIS->get_user_modules(NULL, NULL, 'name');
  } else {
    $modules = $CIS->get_user_modules($_user->id, NULL, 'name');
  }

    echo "<table>";
    if (count($modules) > 0) {
      foreach ($modules as $id => $module) {
        $checked_str = (isset($_module_id) && ($id == $_module_id)) ? ' checked="checked"' : '' ;
        echo('<tr>');
        echo("  <td><input type=\"radio\" name=\"module_id\" id=\"module_{$id}\" value=\"{$id}\"{$checked_str} /></td>");
        echo("  <td><label style=\"font-weight: normal;\" for=\"module_{$id}\">{$module['module_title']} [{$module['module_code']}]</label></td>");
        echo('</tr>');
      }
    } else {
      echo('<tr>');
      echo('  <td colspan="2">No modules</td>');
      echo('</tr>');
    }
?>
</table>
</div>
<?php
  if (count($modules) > 0) {
?>
<p>
<input type="submit" value="Select module" />
</p>
<?php
  }
?>
</form>
<?php

$UI->content_end();

?>


