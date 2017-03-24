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


