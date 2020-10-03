<?php
    include_once '../db/database.php';
    session_start();

    if ($_SESSION['logged_in'] == false) {
        $_SESSION['message'] = "You are not Signed In.! <br> Please Sign in.";
        die(header('Location: ../error.php'));
    }
    $sql = "SELECT * FROM test_bank WHERE staff_id = {$_SESSION['staff_id']}";
    $result = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<html>
<head>
    <?php  include '../include/meta_include.php' ?>
    <meta charset="utf-8">
    <title>My Test</title>
    <?php  include '../include/css_include.php' ?>
    <link rel="stylesheet" href="../css/master.css">
    <?php  include '../include/staff_navbar_css.php' ?>
</head>
<body>
    <!--Navbar-->
    <?php include '../include/staff_navbar_include.php' ?>

    <!--My Test-->
    <div class="content-wrapper my-5">
        <div class="container my-5">
            <h2 class="ml-5 display-4" style="font-size: 30px">My Test</h2>
            <hr>
            <?php
                echo "<div class='row mx-5'>";
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['neg_marks'] > 0) {
                            $neg_marks = 'YES';
                        }else {
                            $neg_marks = 'NO';
                        }
                        if ($row['test_time'] > 0) {
                            $test_time = 'YES';
                        }else {
                            $test_time = 'NO';
                        }
                        echo"<div class='col-md-4 my-4'>
                                <div class='card' style='width: 18rem;'>";
                                echo"   <form class='card-body' action='test_review.php' method='POST'>
                                            <h5 class='card-title display-4' style='font-size:25px;'><i>".$row['test_name']."</i></h5>
                                            <h6 class='card-subtitle mb-1 text-muted'><i>".$row['test_stream']."</i></h6>
                                            <h7 class='card-subtitle mb-3 text-muted'><i>".$row['test_subject']."</i></h7>
                                            <p class='card-text'>Number of questions: <i>".$row['number_of_questions']."</i></p>
                                            <p class='card-text'>Negative Marks: <i>".$neg_marks."</i></p>";
                                            if ($row['neg_marks'] > 0) {
                                                echo "<p class='card-text'>Wrong Option: <i>-".$row['neg_marks']."</i></p>";
                                            }
                                echo"       <p class='card-text'>Test Time: <i>".$test_time."</i></p>";
                                            if ($row['test_time'] > 0) {
                                                echo "<p class='card-text'>Test Time: <i>".$row['test_time']."</i></p>";
                                            }
                                echo"       <input type='hidden' name='test_id' value='".$row['test_id']."'>
                                            <input type='hidden' name='test_name' value='".$row['test_name']."'>
                                            <button type='submit' class='btn btn-outline-warning'>Review</button>
                                            <button type='submit' class='btn btn-outline-info ml-2' formaction='edit_my_test.php'>Edit</button>
                                            
                                        </form>
                                </div>
                            </div>";
                    }
                    echo "</div>";
                }else {
                    echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>You haven't created any test yet, click on Create Test.</div><br>";
                }
            ?>
        </div>
    </div>
    <!--Footer-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © Exam-in 2018</small>
            </div>
        </div>
    </footer>
    <?php  include '../include/create_test_modal_include.php' ?>
    <?php include '../include/js_include.php' ?>
    <?php include '../include/staff_master_js_include.php' ?>
</body>
</html>

<!-- 
<button class='btn btn-outline-danger ml-2' formaction='../admin/test_delete.php' name='submitTest' type='submit' data-toggle='tooltip'
                data-placement='top' title='Delete'>Delete</button> -->