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

/* Update Profile */
if (isset($_POST['Update_Profile'])) {

    $Admin_Login_id = $_SESSION['Login_id'];
    $Admin_full_name = $_POST['Admin_full_name'];
    $Admin_contact = $_POST['Admin_contact'];
    $Admin_email  = $_POST['Admin_email'];
    $Admin_username  = $_POST['Admin_username'];

    $query = "UPDATE admin SET  Admin_full_name =?, Admin_contact =?, Admin_email =?, Admin_username =? WHERE Admin_Login_id =?    ";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssss', $Admin_full_name, $Admin_contact, $Admin_email, $Admin_username, $Admin_Login_id);
    $stmt->execute();

    if ($stmt) {
        $success = "$Admin_full_name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Update Auth Details */

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
        $ret = "SELECT * FROM admin WHERE Admin_Login_id = '$Login_id' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($admin = $res->fetch_object()) {
        ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $admin->Admin_full_name; ?> Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                    <li class="breadcrumb-item active">User Profile</li>
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

                                        <h3 class="profile-username text-center"><?php echo $admin->Admin_full_name; ?></h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Contacts:</b> <a class="float-right"><?php echo $admin->Admin_contact; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $admin->Admin_email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Username:</b> <a class="float-right"><?php echo $admin->Admin_username; ?></a>
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
                                                <form class="form-horizontal" method="POST">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Full Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" required name="Admin_full_name" value="<?php echo $admin->Admin_full_name; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Contact</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" required name="Admin_contact" value="<?php echo $admin->Admin_contact; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" required name="Admin_email" value="<?php echo $admin->Admin_email; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Username</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" required name="Admin_username" value="<?php echo $admin->Admin_username; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <div class="offset-sm-2 text-right col-sm-10">
                                                            <button type="submit" name="Update_Profile" class="btn btn-danger">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="timeline">
                                                <?php
                                                $ret = "SELECT * FROM login WHERE Login_id = '$Login_id' ";
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
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Old Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" required name="old_password" class="form-control">
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