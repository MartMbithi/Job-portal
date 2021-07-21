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

/* Update Profile */
if (isset($_POST['update_student'])) {
    $Student_Full_Name = $_POST['Student_Full_Name'];
    $Student_ID_Passport = $_POST['Student_ID_Passport'];
    $Student_Gender = $_POST['Student_Gender'];
    $Student_DOB = $_POST['Student_DOB'];
    $Student_Nationality  = $_POST['Student_Nationality'];
    $Student_location = $_POST['Student_location'];
    $Student_Contacts  = $_POST['Student_Contacts'];
    $Student_Email = $_POST['Student_Email'];
    $Student_Highest_educational_attainment = $_POST['Student_Highest_educational_attainment'];
    $Student_Id = $_POST['Student_Id'];

    $student_CV = time() . $_FILES['student_CV']['name'];
    move_uploaded_file($_FILES["student_CV"]["tmp_name"], "../public/uploads/user_data/" . time() . $student_CV);

    $student_Documents =  time() . $_FILES['student_Documents']['name'];
    move_uploaded_file($_FILES["student_Documents"]["tmp_name"], "../public/uploads/user_data/" . time() . $student_Documents);



    $query = "UPDATE student SET  Student_Full_Name =?, Student_ID_Passport =?, student_Documents =?,  student_CV=?, Student_Gender =?, Student_DOB =?, Student_Nationality =?,  Student_location =?, 
        Student_Contacts =?, Student_Email =?, Student_Highest_educational_attainment =? WHERE Student_Id =?";

    $stmt = $mysqli->prepare($query);

    $rc = $stmt->bind_param(
        'ssssssssssss',
        $Student_Full_Name,
        $Student_ID_Passport,
        $student_Documents,
        $student_CV,
        $Student_Gender,
        $Student_DOB,
        $Student_Nationality,
        $Student_location,
        $Student_Contacts,
        $Student_Email,
        $Student_Highest_educational_attainment,
        $Student_Id
    );

    $stmt->execute();

    if ($stmt) {
        $success = "$Student_Full_Name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
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
        $Login_id = $_SESSION['Login_id'];
        $ret = "SELECT * FROM student WHERE Student_login_id = '$Login_id' ";
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
                                    <li class="breadcrumb-item"><a href="std_home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="std_home">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
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
                                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Update Profile</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Update Login Credentials</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                                <form method="post" enctype="multipart/form-data" role="form">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="">Full Name</label>
                                                                <input type="text" required name="Student_Full_Name" value="<?php echo $student->Student_Full_Name; ?>" class="form-control">
                                                                <input type="hidden" required name="Student_Id" value="<?php echo $student->Student_Id; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">ID / Passport Number</label>
                                                                <input type="text" required name="Student_ID_Passport" value="<?php echo $student->Student_ID_Passport; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">Gender</label>
                                                                <select type="text" required name="Student_Gender" class="form-control">
                                                                    <option><?php echo $student->Student_Gender; ?></option>
                                                                    <option>Male</option>
                                                                    <option>Female</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">D.O.B</label>
                                                                <input type="date" required name="Student_DOB" value="<?php echo $student->Student_DOB; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">Nationality</label>
                                                                <input type="text" required name="Student_Nationality" value="<?php echo $student->Student_Nationality; ?>" class="form-control">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="">Location</label>
                                                                <input type="text" required name="Student_location" value="<?php echo $student->Student_location; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Contacts</label>
                                                                <input type="text" required name="Student_Contacts" value="<?php echo $student->Student_Contacts; ?>" class="form-control">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="">Email</label>
                                                                <input type="email" required name="Student_Email" value="<?php echo $student->Student_Email; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Highest Education Level Attained</label>
                                                                <select type="text" required name="Student_Highest_educational_attainment" class="form-control">
                                                                    <option><?php echo $student->Student_Highest_educational_attainment; ?></option>
                                                                    <option>Primary School</option>
                                                                    <option>Secondary School</option>
                                                                    <option>Tertiary</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">CV</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" required accept=".docx, .pdf, .doc" name="student_CV" class="custom-file-input" id="exampleInputFile">
                                                                        <label class="custom-file-label " for="exampleInputFile">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="">Student Documents</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" required accept=".docx, .pdf, .doc" name="student_Documents" class="custom-file-input" id="exampleInputFile">
                                                                        <label class="custom-file-label " for="exampleInputFile">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="update_student" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
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