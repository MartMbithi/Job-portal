<?php
/*
 * Created on Mon Jul 19 2021
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
require_once('../config/codeGen.php');
checklogin();

/* Add Company  */
if (isset($_POST['add_company'])) {
    $Company_name = $_POST['Company_name'];
    $Company_location = $_POST['Company_location'];
    $Company_contact = $_POST['Company_contact'];
    $Company_email = $_POST['Company_email'];
    $Company_Category_id  = $_POST['Company_Category_id'];
    $Company_website = $_POST['Company_website'];
    $company_login_id  = $_POST['company_login_id'];
    $company_account_status = 'Approved';

    /* Company Auth  */
    $Login_username = $_POST['Login_username'];
    $Login_password = sha1(md5($_POST['Login_password']));
    $Login_rank = 'Company';

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  company WHERE Company_name = '$Company_name'   ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($Company_name == $row['Company_name']) {
            $err =  "$Company_name Already Exists";
        }
    } else {
        $query = "INSERT INTO company (Company_name, Company_location, Company_contact, Company_email, Company_Category_id, Company_website, company_login_id, company_account_status) VALUES(?,?,?,?,?,?,?,?)";
        $auth = "INSERT INTO login (Login_id, Login_username, Login_password, Login_rank) VALUES(?,?,?,?)";

        $stmt = $mysqli->prepare($query);
        $authstmt = $mysqli->prepare($auth);

        $rc = $stmt->bind_param('ssssssss', $Company_name, $Company_location, $Company_contact, $Company_email, $Company_Category_id, $Company_website, $company_login_id, $company_account_status);
        $rc = $authstmt->bind_param('ssss', $company_login_id, $Login_username, $Login_password, $Login_rank);

        $stmt->execute();
        $authstmt->execute();

        if ($stmt && $authstmt) {
            $success = "$Company_name Account Added";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Update Company  */
if (isset($_POST['update_company'])) {
    $Company_name = $_POST['Company_name'];
    $Company_location = $_POST['Company_location'];
    $Company_contact = $_POST['Company_contact'];
    $Company_email = $_POST['Company_email'];
    $Company_website = $_POST['Company_website'];
    $Company_id = $_POST['Company_id'];

    /**/
    $query = "UPDATE company SET Company_name =?, Company_location =?, Company_contact =?, Company_email =?, Company_website =? WHERE Company_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssss', $Company_name, $Company_location, $Company_contact, $Company_email, $Company_website, $Company_id);
    $stmt->execute();

    if ($stmt) {
        $success = "$Company_name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Delete Company Category */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $auth = $_GET['auth'];

    $adn = "DELETE FROM company WHERE Company_id=?";
    $auth_del = "DELETE FROM login WHERE Login_id = ?";

    $stmt = $mysqli->prepare($adn);
    $auth_stmt = $mysqli->prepare($auth_del);

    $stmt->bind_param('s', $delete);
    $auth_stmt->bind_param('s', $auth);

    $stmt->execute();
    $auth_stmt->execute();

    $stmt->close();
    $auth_stmt->close();

    if ($stmt && $auth_stmt) {
        $success = "Deleted" && header("refresh:1; url=companies");
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
        <?php require_once('../partials/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-bold">Companies</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Companies</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Company</button>
                    </div>
                    <hr>
                    <!-- Add Modal -->
                    <div class="modal fade" id="add_modal">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Fill All Values </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Company Name</label>
                                                    <input type="text" required name="Company_name" class="form-control">
                                                    <input type="hidden" required name="company_login_id" value="<?php echo $sys_gen_id; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Company Contacts</label>
                                                    <input type="text" required name="Company_contact" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Company Email</label>
                                                    <input type="text" required name="Company_email" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Company Website</label>
                                                    <input type="text" required name="Company_website" class="form-control">
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
                                                <div class="form-group col-md-6">
                                                    <label for="">Company Login Username</label>
                                                    <input type="text" required name="Login_username" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Company Login Password</label>
                                                    <input type="password" required name="Login_password" class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleInputPassword1">Company Location</label>
                                                    <textarea name="Company_location" rows="2" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_company" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Company Category</th>
                                        <th>Company Contacts</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM company_categories cc INNER JOIN company c ON c.Company_Category_id = cc.category_id";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($companies = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $companies->Company_name; ?></td>
                                            <td><?php echo $companies->Category_name; ?></td>
                                            <td>
                                                Contact: <?php echo $companies->Company_contact; ?><br>
                                                Email: <?php echo $companies->Company_email; ?><br>
                                                Website: <?php echo $companies->Company_website; ?>
                                            </td>
                                            <td>
                                                <a class="badge badge-success" href="company?view=<?php echo $companies->Company_id; ?>">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                <a class="badge badge-primary" data-toggle="modal" href="#edit-<?php echo $companies->Company_id; ?>">
                                                    <i class="fas fa-edit"></i>
                                                    Update
                                                </a>
                                                <a class="badge badge-danger" data-toggle="modal" href="#delete-<?php echo $companies->Company_id; ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>
                                                <!-- Update Modal -->
                                                <div class="modal fade" id="edit-<?php echo $companies->Company_id; ?>">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Fill All Values </h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" enctype="multipart/form-data" role="form">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Company Name</label>
                                                                                <input type="text" required name="Company_name" value="<?php echo $companies->Company_name; ?>" class="form-control">
                                                                                <input type="hidden" required name="Company_id" value="<?php echo $companies->Company_id; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Company Contacts</label>
                                                                                <input type="text" required name="Company_contact" value="<?php echo $companies->Company_contact; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Company Email</label>
                                                                                <input type="text" required name="Company_email" value="<?php echo $companies->Company_email; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Company Website</label>
                                                                                <input type="text" required name="Company_website" value="<?php echo $companies->Company_website; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="exampleInputPassword1">Company Location</label>
                                                                                <textarea name="Company_location" rows="2" class="form-control"><?php echo $companies->Company_location; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="submit" name="update_company" class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete-<?php echo $companies->Company_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Delete <?php echo $companies->Company_name; ?> ?</h4>
                                                                <br>
                                                                <p>Heads Up, You are about to delete <?php echo $companies->Company_name; ?>. This action is irrevisble.</p>
                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                <a href="companies?delete=<?php echo $companies->Company_id; ?>&auth=<?php echo $companies->company_login_id; ?>" class="text-center btn btn-danger"> Delete </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Main Footer -->
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>