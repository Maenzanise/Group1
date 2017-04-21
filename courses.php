<?php
require 'core/init.php';

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}
$courses = new Courses;
include 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <!--Only admin to be able to see this-->
<!--                <li><a href="#">Link 1</a></li>

                <li><a href="#">Link 2</a></li>
                <li><a href="#">Link 3</a></li>-->
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>

            <div class="well well-sm">
                Hi {name}. Please click on any of the courses below to view additional content.
            </div>

            <h2 class="sub-header">Courses</h2>
            <div class="row">
                <div class="col-sm-9">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Course id</th>
                                    <th>Course name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $courseList = $courses->getAllCourses(); ?>
<?php while ($item = $courseList->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $item['id'] ?></td>
                                        <td><a href="course.php?course_id=<?= $item['id'] ?>"><?= $item['name'] ?></a></td>
                                    </tr>
<?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">My Groups</p>
                        </div>
                        <div class="list-group">
                            <div class="list-group-item">Group 1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
