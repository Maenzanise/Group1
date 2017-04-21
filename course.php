<?php
if (!filter_input(1, "course_id")) {
    header("location: index.php");
}
require 'core/init.php';

$user = new User;
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $comment = filter_input(0, "comment");

    if ($_SESSION['account_type'] == "1") {
        if ($comment) {
            if ($user->addComment($_SESSION['user_id'], $comment, filter_input(1, "course_id"))) {
                $message = "Comment added successfully";
            } else {
                die("something went wrong" . $user->error);
            }
        }
    } else {
        if ($comment) {
            if ($user->addReply($_POST['comment_id'], $comment, $_SESSION['user_id'])) {
                $message = "Comment added successfully";
            } else {
                die("something went wrong" . $user->error);
            }
        }
    }
}

$course = new Courses();
$couseDetails = $course->getCourseDetails(filter_input(1, "course_id"))->fetch_assoc();
$courseDocs = $course->getCourseDocuments(filter_input(1, "course_id"));
if ($_SESSION['account_type'] == "1") {
    $comments = $user->getMyComments($_SESSION['user_id'], filter_input(1, "course_id"));
} elseif ($_SESSION['account_type'] == "0") {
    $comments = $user->getAllComments(filter_input(1, "course_id"));
}

$title = "Course";
include 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <!--Only admin to be able to see this-->
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><?= $couseDetails['name'] ?></h1>

            <h2 class="sub-header">Information</h2>
            <div class="panel">
                <?= $couseDetails['notes'] ?>
            </div>
            <div class="well well-sm">
                <ul>
                    <?php while ($row = $courseDocs->fetch_assoc()): ?>
                        <li><a href="<?= $row['path'] ?>"><?= $row['name'] ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php if ($_SESSION['account_type'] == '1'): ?>
                <form method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading">Comment</div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea class="form-control" name="comment"></textarea>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input type="submit" value="Comment" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            <?php endif; ?>
            <?php if (isset($message)): ?>
                <div class="alert alert-info">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <?php while ($comment = $comments->fetch_assoc()): ?>
                <div class="panel">
                    <?php 
                    $student = $user->getFullName($comment['user_id']);
                    ?>
                    <i><?=$student?>:</i> <?= $comment['comment'] ?>

                    <?php
                    $replies = $user->getReplies($comment['id']);
                    ?>
                    <ul>
                        <?php while ($row = $replies->fetch_assoc()): ?>
                        <li><?=$row['reply'];?></li>
                        <?php endwhile; ?>
                    </ul>

                    <?php if ($_SESSION['account_type'] == "0"): ?>

                        <form method="post" class="clearfix">
                            <div class="reply" 
                                 style="width: 50%; 
                                 border: 1px solid #ccc; 
                                 padding: 10px; 
                                 margin-top: 10px; 
                                 margin-bottom: 10px; 
                                 margin-right: auto;
                                 border-radius: 5px;">
                                <div class="form-group">
                                    <label for="comment">Reply</label>
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>

                                <input type="hidden" name="student" value="<?= $comment['user_id'] ?>">
                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                <input type="submit" value="Reply" class="btn btn-primary">

                            </div>
                        </form>

                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
