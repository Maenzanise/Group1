<?php
require 'core/init.php';

$user = new User;
$groups = $user->getUserGroups();
$groupList = $user->getUserGroups();
// Check if the user has the rights
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
} elseif ($_SESSION['account_type'] != '0') {
    header("location: courses.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
//    var_dump($_POST);

    $group = filter_input(0, 'group');

    $studentIds = $_POST['student'];
    for ($i = 0; $i < sizeof($studentIds); $i++) {
        $user->addStudentToGroup($studentIds[$i], $group);
    }
}
include 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="admin.php">Overview <span class="sr-only">(current)</span></a></li>
                <!--Only admin to be able to see this-->
                <!--Only admin to be able to see this-->
                <li><a href="students.php">Students</a></li>

                <li class="active"><a href="#">Groups</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="margin-top: 10px;">
            <h1 class="page-header">Groups</h1>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add users to group.
                        </div>
                        <div class="panel-body">
                            <form method="POST">

                                <select name='group' class="form-control">
                                    <option value="0"> -- Please Select A group -- </option>
                                    <?php while ($item = $groups->fetch_assoc()): ?>
                                        <option  value="<?= $item['id'] ?>"><?= $item['name']; ?></option>
                                    <?php endwhile; ?>
                                </select>

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Student Name</td>
                                            <td>Select</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $students = $user->getAllStudents();
                                        ?>
                                        <?php while ($row = $students->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['first_name'] . " " . $row['surname'] ?></td>
                                                <td><input type="checkbox" name='student[]' value="<?=$row['id'];?>"></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <div class='panel'>
                                    <input type="submit" value='Add' class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">Group Info</p>
                        </div>
                        <?php while ($row = $groupList->fetch_assoc()): ?>
                            <div class="list-group">
                                <a href="#" class="list-group-item group-toggle" data-id="<?= $row['id'] ?>"><?= $row['name'] ?></a>
                            </div>
                        <?php endwhile; ?>
                        <div class="panel-body">
                            <ul class="" id="students">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
