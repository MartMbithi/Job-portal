<?php
/*
 * Created on Wed Jul 21 2021
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

/* Update Company  */
if (isset($_POST['update_company'])) {
    $Company_name = $_POST['Company_name'];
    $Company_location = $_POST['Company_location'];
    $Company_contact = $_POST['Company_contact'];
    $Company_email = $_POST['Company_email'];
    $Company_website = $_POST['Company_website'];
    $Company_id = $_POST['Company_id'];
    $Company_Category_id  = $_POST['Company_Category_id'];


    /**/
    $query = "UPDATE company SET Company_name =?, Company_location =?, Company_contact =?, Company_Category_id =?, Company_email =?, Company_website =? WHERE Company_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssssss', $Company_name, $Company_location, $Company_contact, $Company_Category_id, $Company_email, $Company_website, $Company_id);
    $stmt->execute();

    if ($stmt) {
        $success = "$Company_name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Update Auth */
if (isset($_POST['Update_Auth'])) {

    $Login_id = $_POST['Login_id'];
    $Login_username = $_POST['Login_username'];
    $new_password  = sha1(md5($_POST['new_password']));
    $confirm_password  = sha1(md5($_POST['confirm_password']));

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
        $Login_id = $_SESSION['Login_id'];
        $ret = "SELECT * FROM company_categories cc INNER JOIN company c ON c.Company_Category_id = cc.category_id WHERE c.company_login_id = '$Login_id'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($company = $res->fetch_object()) {
        ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $company->Company_name; ?> Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="company_home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="company_home">Dashboard</a></li>
                                    <li class="breadcrumb-item active"><?php echo $company->Company_name; ?></li>
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
                                            <img class="profile-user-img img-fluid img-circle" src="../public/img/company.png" alt="User profile picture">
                                        </div>

                                        <h3 class="profile-username text-center"><?php echo $company->Company_name; ?></h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Contacts:</b> <a class="float-right"><?php echo $company->Company_contact; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $company->Company_email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Website:</b> <a class="float-right"><?php echo $company->Company_website; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Location:</b> <a class="float-right"><?php echo $company->Company_location; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Category:</b> <a class="float-right"><?php echo $company->Category_name; ?></a>
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
                                            <li class="nav-item"><a class="nav-link active" href="#add_job" data-toggle="tab">Update Company Profile</a></li>
                                            <li class="nav-item"><a class="nav-link " href="#timeline" data-toggle="tab">Update Company Login Credentials</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane active" id="add_job">
                                                <form method="post" enctype="multipart/form-data" role="form">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="">Company Name</label>
                                                            <input type="text" required name="Company_name" value="<?php echo $company->Company_name; ?>" class="form-control">
                                                            <input type="hidden" required name="Company_id" value="<?php echo $company->Company_id; ?>" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">Company Contacts</label>
                                                            <input type="text" required name="Company_contact" value="<?php echo $company->Company_contact; ?>" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">Company Email</label>
                                                            <input type="text" required name="Company_email" value="<?php echo $company->Company_email; ?>" class="form-control">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="">Company Website</label>
                                                            <input type="text" required name="Company_website" value="<?php echo $company->Company_website; ?>" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="">Company Category</label>
                                                            <select id="CategoryName" onchange="GetCompanyCategoryDetails(this.value)" class="form-control">
                                                                <option>Select Category Name</option>
                                                                <?php
                                                                $ret = "SELECT * FROM company_categories ";
                                                                $stmt = $mysqli->prepare($ret);
                                                                $stmt->execute(); //ok
                                                                $res = $stmt->get_result();
                                                                while ($categories = $res->fetch_object()) {
                                                                ?>
                                                                    <option><?php echo $categories->Category_name; ?></option>
                                                                <?php
                                                                } ?>
                                                            </select>
                                                            <input type="hidden" required name="Company_Category_id" id="CategoryID" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="exampleInputPassword1">Company Location</label>
                                                            <textarea name="Company_location" rows="2" class="form-control"><?php echo $company->Company_location; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="update_company" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="timeline">
                                                <?php
                                                $ret = "SELECT * FROM login WHERE Login_id = '$company->company_login_id' ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($company_auth = $res->fetch_object()) {
                                                ?>
                                                    <form class="" method="POST">
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Login Username</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" required name="Login_username" value="<?php echo $company_auth->Login_username; ?>" class="form-control">
                                                                <input type="hidden" required name="Login_id" value="<?php echo $company_auth->Login_id; ?>" class="form-control">
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