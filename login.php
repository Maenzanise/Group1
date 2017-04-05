<?php
include("inc_global.php");// Establishing connection with our database
/**
 * Created by PhpStorm.
 * User: 1611403
 * Date: 23/03/2017
 * Time: 14:48
 */
//echo $error;?>
<?php
//echo $username; echo $password;
?>
</div>
<h1>Login form</h1>
<div class="login box">
    <h3>Please login to continue</h3>
    <br><br>
    <form method="post" action="login.php">
        <label >Username:</label><br>
        <input type="text" name="username" placeholder="username"/>
        <br><br>
        <label>Password:</label>
        <br><input type="password" name="password" placeholder="password"/>
        <br><br >         <input type="submit" name="submit" value = "login"/>
    </form>     <div class="error">

    </div>

    {
    <?php
    //if(empty($_POST["username"]) || empty($_POST["password"]))
    //echo "Both fields are required.";

    ?>
    }
    <?php
    // else
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT uid FROM users
             WHERE username='$username' and password='$password'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) == 1) {
        {
            header("location:index.html");
        }

        // Redirecting To another Page
        // else
// echo "Incorrect username or password.";


    }


    ?>


