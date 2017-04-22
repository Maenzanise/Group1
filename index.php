<?php
require 'core/init.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user = new User();
//    var_dump($_POST);
     $email = filter_input(0, "email");
     $password = filter_input(0, "password");
     
     if($user->check_login($email, sha1($password))){
         
         $user->login();
         header("location: admin.php");
     }else{
         die("wrong info");
     }
     
}
$title = "Home";
include 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Login</h1>

            <div class="well well-sm">
                Please enter your email and password below
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2">
                    <form role="form" class="sign_up_form"method="post">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email address" tabindex="4">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Email address" tabindex="4">
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12"><input type="submit" class="btn btn-success btn-block btn-lg" value="Login"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
include 'includes/footer.php';
