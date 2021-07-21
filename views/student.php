<?php
/*
 * Created on Tue Jul 20 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 MartDevelopers Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
checklogin();

/* Update Auth Details */
if (isset($_POST['Update_Auth'])) {

    $Login_id = $_POST['Login_id'];
    $Login_username = $_POST['Login_username'];
    $new_password  = sha1(md5($_POST['new_password']));
    $confirm_password  = sha1(md5($_POST['confirm_password']));
    /* Check If Old Passwords Match */
    if ($new_password != $confirm_password) {
        $err = "Confirmation Password Does Not Match";
    } else {
        $query = "UPDATE login SET  Login_username =?, Login_password =? WHERE Login_id =?    ";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sss', $Login_username, $confirm_password, $Login_id);
        $stmt->execute();
        if ($stmt) {
            $success = "$Login_username Account Login Details Updated";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

require_once('../partials/head.php');
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once('../partials/navbar.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once('../partials/sidebar.php');
        $view = $_GET['view'];
        $ret = "SELECT * FROM student WHERE Student_id = '$view' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($student = $res->fetch_object()) {
        ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $student->Student_Full_Name; ?> Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="">Students</a></li>
                                    <li class="breadcrumb-item active">Student Profile</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Profile Image -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="../public/img/no-profile.png" alt="User profile picture">
                                        </div>

                                        <h3 class="profile-username text-center"><?php echo $student->Student_Full_Name; ?></h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>ID / Passport:</b> <a class="float-right"><?php echo $student->Student_ID_Passport; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Gender:</b> <a class="float-right"><?php echo $student->Student_Gender; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>D.O.B: </b> <a class="float-right"><?php echo date('d M Y', strtotime($student->Student_DOB)); ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Nationality:</b> <a class="float-right"><?php echo $student->Student_Nationality; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Location:</b> <a class="float-right"><?php echo $student->Student_location; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Contacts:</b> <a class="float-right"><?php echo $student->Student_Contacts; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email:</b> <a class="float-right"><?php echo $student->Student_Email; ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->

                            </div>
                            <!-- /.col -->
                            <div class="col-md-8">
                                <div class="card card-primary card-outline">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab"><?php echo $student->Student_Full_Name; ?> Documents</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Update Login Credentials</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                                <div class="text-center">
                                                    <a target="_blank" href="../public/uploads/user_data/<?php echo $student->student_CV; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i>Download CV</a>
                                                    <a target="_blank" href="../public/uploads/user_data/<?php echo $student->student_Documents; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i>Download Other <?php echo $student->Student_Full_Name; ?> Documents</a>
                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="timeline">
                                                <?php
                                                $ret = "SELECT * FROM login WHERE Login_id = '$student->Student_Login_id' ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($admin_auth = $res->fetch_object()) {
                                                ?>
                                                    <form class="" method="POST">
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Login Username</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" required name="Login_username" value="<?php echo $admin_auth->Login_username; ?>" class="form-control">
                                                                <input type="hidden" required name="Login_id" value="<?php echo $student->Student_Login_id; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">New Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" required name="new_password" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" required name="confirm_password" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row ">
                                                            <div class="offset-sm-2 text-right col-sm-10">
                                                                <button type="submit" name="Update_Auth" class="btn btn-danger">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div><!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php } ?>
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>