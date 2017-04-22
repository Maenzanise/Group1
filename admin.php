<?php
require 'core/init.php';
// Check if the user has the rights

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}elseif($_SESSION['account_type'] != '0'){
    header("location: courses.php");
}

$user = new User();
$courses = new Courses();
$savedCourses = $courses->getAllCourses();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // GET THE TYPE OF POST SUBMITTED
    if (filter_input(0, "action") == "add_student") {

        // BASIC ERROR HANDLING
        $name = filter_input(0, "name", FILTER_SANITIZE_STRING);
        $surname = filter_input(0, "surname", FILTER_SANITIZE_STRING);
        $email = filter_input(0, "email", FILTER_SANITIZE_EMAIL);
        $password = substr($name, 0, 3) . substr($surname, 0, 3) . substr($email, 0, 3);

        $hash = sha1($password);

        if ($name && $surname && $email) {
            // SAVE DATA
            if ($user->createStudentAccount($name, $surname, $email, $hash, 1)) {
                $message = "Successfully created the account";
            } else {
                $message = "Unable to create the account: " . $user->error;
            }
        } else {
            // NOTIFY USER THAT THERE WAS AN ERROR
        }
    } elseif (filter_input(0, "action") == "add_course") {

        $name = filter_input(0, "name", FILTER_SANITIZE_STRING);
        $description = filter_input(0, "description", FILTER_SANITIZE_STRING);

        if ($name && $description) {
            if ($courses->addNewCourse($name, $description)) {
                $courseId = $courses->insertId;

                foreach ($_FILES as $item) {

                    $folder = 'docs/';
                    $name = $courseId . "_" . str_replace(' ', '_', $item['name']);
                    $destination = $folder . $name;

                    $upload = move_uploaded_file($item['tmp_name'], $folder . $name);

                    if ($upload) {
                        $courses->addSupportingDocs($courseId, $name, $destination);
                    }

                    echo $name;
                }
            } else {
                die($courses->error);
            }
        } else {
            // Unable to perform action :(
        }
    } elseif (filter_input(0, "action") == "add_group") {
        $name = filter_input(0, "name", FILTER_SANITIZE_STRING);
        $course = filter_input(0, "course", FILTER_SANITIZE_NUMBER_INT);
        
        if($name && $course){
            if($user->createNewGroup($name, $course)){
                $message = "Group created";
            }else{
                $message = "Unable to create group: " . $user->error;
            }
        }else{
            var_dump($course);
            die("unable to create a group.");
        }
    }
//    die("I am getting post data.");
}
$title = "Dashboard";
include 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <!--Only admin to be able to see this-->
                <!--<li><a href="students.php">Students</a></li>-->

                <!--<li><a href="#">Courses</a></li>-->
                <li><a href="groups.php">Groups</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-info">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <div class="well well-sm">
                Please click on any of the following to perform task.
            </div>

            <button class="btn btn-success" data-toggle="modal" data-target="#myModal-1">Add Student</button>
            <button class="btn btn-success" data-toggle="modal" data-target="#myModal-2">Add Course</button>
            <button class="btn btn-success" data-toggle="modal" data-target="#myModal-3">Create Group</button>

            <h2 class="sub-header">Courses</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course id</th>
                            <th>Course name</th>
                            <th>Number of views</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $courseList = $courses->getAllCourses();?>
                        <?php while($item = $courseList->fetch_assoc()):?>
                        <tr>
                            <td><?=$item['id']?></td>
                            <td><a href="course.php?course_id=<?=$item['id']?>"><?=$item['name']?></a></td>
                            <td><i>NULL</i></td>
                            <td><button class="btn btn-danger" disabled="">Remove</button></td>
                        </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal 1 = Add Student-->
        <div id="myModal-1" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post">
                        <input type="hidden" name="action" value="add_student">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add student</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label form="name">First Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label form="surname">Surname</label>
                                <input type="text" name="surname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label form="email">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Add Student" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Modal 2 = Add Course-->
        <div id="myModal-2" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add_course">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Course</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label form="name">Course Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label form="name">Course Description</label>
                                <textarea type="text" name="description" class="form-control"
                                          placeholder="Enter course description and type any notes in this area"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="docs">Supporting doc(s)</label>
                                <input type="file" name="docs[]" class="form-control" multiple>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Add Course" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Modal 1 = Add Group-->
        <div id="myModal-3" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post">
                        <input type="hidden" name="action" value="add_group">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Create Group</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label form="name">Group Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label form="course">Course</label>
                                <select name="course" class="form-control">
                                    <option value="0"> -- Please Select a course -- </option>
                                    <?php while ($row = $savedCourses->fetch_assoc()): ?>
                                        <option value="<?= $row['id'] ?>"> <?= $row['name'] ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Create" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<?php
include 'includes/footer.php';
