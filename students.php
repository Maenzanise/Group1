<?php 

require 'core/init.php';
// Check if the user has the rights
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}elseif($_SESSION['account_type'] != '0'){
    header("location: courses.php");
}

include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="admin.php">Overview <span class="sr-only">(current)</span></a></li>
                <li class="active"><a href="#">Students</a></li>
                
                <li><a href="groups.php">Groups</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>

            <div class="well well-sm">
                This is a well for any information or text you wish to show.
            </div>

            <h2 class="sub-header">Heading</h2>
                This is page specific content.
            </div>
    </div>
</div>
<?php include 'includes/footer.php';