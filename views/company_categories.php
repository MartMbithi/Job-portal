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
checklogin();
/* Add Company Category */
if (isset($_POST['add_category'])) {
    $Category_name = $_POST['Category_name'];
    $Category_desc = $_POST['Category_desc'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  company_categories WHERE Category_name = '$Category_name'   ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($Category_name == $row['Category_name']) {
            $err =  "$Category_name Already Exists";
        }
    } else {
        $query = "INSERT INTO company_categories (Category_name, Category_desc ) VALUES(?,?) ";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss', $Category_name, $Category_desc);
        $stmt->execute();

        if ($stmt) {
            $success = "$Category_name Added";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Update Company Category */
if (isset($_POST['add_category'])) {
    $Category_name = $_POST['Category_name'];
    $Category_desc = $_POST['Category_desc'];
    $Category_id = $_POST['Category_id'];

    $query = "UPDATE  company_categories SET  Category_name =?, Category_desc =? WHERE Category_id = ? ";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sss', $Category_name, $Category_desc, $Category_id);
    $stmt->execute();

    if ($stmt) {
        $success = "$Category_name Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Delete Company Category */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM company_categories WHERE id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=company_categories");
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
                            <h1 class="m-0 text-bold">Company Categories</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Company Categories</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Company Category</button>
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
                                                <div class="form-group col-md-12">
                                                    <label for="">Company Category Name</label>
                                                    <input type="text" required name="Category_name" class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleInputPassword1">Company Category Details</label>
                                                    <textarea name="Category_desc" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_category" class="btn btn-primary">Submit</button>
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
                                        <th>Category Name</th>
                                        <th>Category Details </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM company_categories ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($categories = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $categories->Category_name; ?></td>
                                            <td><?php echo $categories->Category_desc; ?></td>
                                            <td>
                                                <a class="badge badge-primary" data-toggle="modal" href="#edit-<?php echo $categories->Category_id; ?>">
                                                    <i class="fas fa-edit"></i>
                                                    Update
                                                </a>
                                                <a class="badge badge-danger" data-toggle="modal" href="#delete-<?php echo $categories->Category_id; ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>
                                                <!-- Update Modal -->
                                                <!-- End Modal -->

                                                <!-- Delete Modal -->

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