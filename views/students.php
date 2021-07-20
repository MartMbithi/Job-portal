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

/* Add Student  */
if (isset($_POST['add_student'])) {
    $Student_Full_Name = $_POST['Student_Full_Name'];
    $Student_ID_Passport = $_POST['Student_ID_Passport'];
    $Student_Gender = $_POST['Student_Gender'];
    $Student_DOB = $_POST['Student_DOB'];
    $Student_Nationality  = $_POST['Student_Nationality'];
    $Student_location = $_POST['Student_location'];
    $Student_Contacts  = $_POST['Student_Contacts'];
    $Student_Email = $_POST['Student_Email'];
    $Student_Highest_educational_attainment = $_POST['Student_Highest_educational_attainment'];
    $Student_Login_id = $_POST['Student_Login_id'];
    $Student_account_status = 'Approved';

    $student_CV = time() . $_FILES['student_CV'];
    move_uploaded_file($_FILES["student_CV"]["tmp_name"], "../public/uploads/user_data/" . time() . $student_CV);

    $student_Documents = $_FILES['student_Documents'];
    move_uploaded_file($_FILES["student_Documents"]["tmp_name"], "../public/uploads/user_data/" . time() . $student_Documents);


    /* Student Auth Details */
    $Login_password = sha1(md5($_POST['Login_password']));
    $Login_rank = 'Student';

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  student WHERE Student_ID_Passport = '$Student_ID_Passport' || Student_Email = '$Student_Email'     ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($Student_ID_Passport == $row['Student_ID_Passport'] || $Student_Email == $row['Student_Email']) {
            $err =  "$Student_ID_Passport Or $Student_Email Already Exists";
        }
    } else {
        $query = "INSERT INTO student (Student_Full_Name, Student_ID_Passport, Student_Gender, Student_DOB, Student_Nationality, Student_location, 
        Student_Contacts, Student_Email, Student_Highest_educational_attainment, Student_Login_id, Student_account_status, student_CV, student_Documents)
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $auth = "INSERT INTO login(Login_id, Login_username, Login_password, Login_rank) VALUES(?,?,?,?)";

        $stmt = $mysqli->prepare($query);
        $authstmt = $mysqli->prepare($auth);

        $rc = $stmt->bind_param(
            'sssssssssssss',
            $Student_Full_Name,
            $Student_ID_Passport,
            $Student_Gender,
            $Student_DOB,
            $Student_Nationality,
            $Student_location,
            $Student_Contacts,
            $Student_Email,
            $Student_Highest_educational_attainment,
            $Student_Login_id,
            $Student_account_status,
            $student_CV,
            $student_Documents
        );
        $rc = $authstmt->bind_param('ssss', $Student_Login_id, $Student_Email, $Login_password, $Login_rank);

        $stmt->execute();
        $authstmt->execute();

        if ($stmt && $authstmt) {
            $success = "$Student_Full_Name Account Created";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}


/* Update Student  */
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
    $Student_id = $_POST['Student_id'];


    $query = "UPDATE student SET  Student_Full_Name =?, Student_ID_Passport =?, Student_Gender =?, Student_DOB =?, Student_Nationality =?,  Student_location =?, 
        Student_Contacts =?, Student_Email =?, Student_Highest_educational_attainment =? WHERE Student_Id =?";

    $stmt = $mysqli->prepare($query);

    $rc = $stmt->bind_param(
        'ssssssssss',
        $Student_Full_Name,
        $Student_ID_Passport,
        $Student_Gender,
        $Student_DOB,
        $Student_Nationality,
        $Student_location,
        $Student_Contacts,
        $Student_Email,
        $Student_Highest_educational_attainment,
        $Student_id
    );

    $stmt->execute();

    if ($stmt) {
        $success = "$Student_Full_Name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Delete Student */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $auth_del = $_GET['auth'];

    $adn = "DELETE FROM student WHERE Student_id=?";
    $del_auth = "DELETE FROM login WHERE Login_id = ?";

    $stmt = $mysqli->prepare($adn);
    $auth_stmt = $mysqli->prepare($del_auth);

    $stmt->bind_param('s', $delete);
    $auth_stmt->bind_param('s', $del_auth);

    $stmt->execute();
    $auth_stmt->execute();

    $stmt->close();
    $auth_stmt->close();

    if ($stmt && $auth_del) {
        $success = "Deleted" && header("refresh:1; url=students");
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
                            <h1 class="m-0 text-bold">Posted Jobs</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Jobs</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Post Job Opening</button>
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
                                                <div class="form-group col-md-4">
                                                    <label for="">Job Title</label>
                                                    <input type="text" required name="Job_title" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="">Job Category</label>
                                                    <input type="text" required name="Job_Category" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="">Job Location</label>
                                                    <input type="text" required name="Job_location" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="">Job Apply Date</label>
                                                    <input type="date" required name="Job_apply_date" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="">Job Application Closing Date</label>
                                                    <input type="date" required name="Job_Last_application_date" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="">Job No Of Vacancies</label>
                                                    <input type="number" required name="Job_No_of_vacancy" class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Company Name</label>
                                                    <select id="CompanyName" onchange="GetCompanyDetails(this.value)" class="form-control">
                                                        <option>Select Company Name</option>
                                                        <?php
                                                        $ret = "SELECT * FROM company ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($company = $res->fetch_object()) {
                                                        ?>
                                                            <option><?php echo $company->Company_name; ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                    <input type="hidden" required name="Job_Company_id" id="CompanyID" class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="exampleInputPassword1">Job Description</label>
                                                    <textarea name="Job_description" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_job" class="btn btn-primary">Submit</button>
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
                                        <th>Job Title</th>
                                        <th>Job Category</th>
                                        <th>Company Hiring</th>
                                        <th>Job Location</th>
                                        <th>Job Dates</th>
                                        <th>No Of Vacancies</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM job j INNER JOIN company c ON c.Company_id = j.Job_Company_id ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($jobs = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jobs->Job_title; ?></td>
                                            <td><?php echo $jobs->Job_Category; ?></td>
                                            <td>
                                                Name: <?php echo $jobs->Company_name; ?><br>
                                                Location: <?php echo $jobs->Company_location; ?><br>
                                                Contact : <?php echo $jobs->Company_contact; ?><br>
                                                Email : <?php echo $jobs->Company_email; ?>
                                            </td>
                                            <td><?php echo $jobs->Job_location; ?></td>
                                            <td>
                                                Application Date: <?php echo date('d M Y', strtotime($jobs->Job_apply_date)); ?><br>
                                                Closing Date : <?php echo date('d M Y', strtotime($jobs->Job_Last_application_date)); ?>
                                            </td>
                                            <td><?php echo $jobs->Job_No_of_vacancy; ?></td>
                                            <td>
                                                <a class="badge badge-primary" data-toggle="modal" href="#edit-<?php echo $jobs->Job_id; ?>">
                                                    <i class="fas fa-edit"></i>
                                                    Update
                                                </a>
                                                <a class="badge badge-danger" data-toggle="modal" href="#delete-<?php echo $jobs->Job_id; ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>
                                                <!-- Update Modal -->
                                                <div class="modal fade" id="edit-<?php echo $jobs->Job_id; ?>">
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
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Job Title</label>
                                                                                <input type="text" required name="Job_title" value="<?php echo $jobs->Job_title; ?>" class="form-control">
                                                                                <input type="hidden" required name="Job_id" value="<?php echo $jobs->Job_id; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Job Category</label>
                                                                                <input type="text" required name="Job_Category" value="<?php echo $jobs->Job_Category; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Job Location</label>
                                                                                <input type="text" required name="Job_location" value="<?php echo $jobs->Job_location; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Job Apply Date</label>
                                                                                <input type="date" required name="Job_apply_date" value="<?php echo $jobs->Job_apply_date; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Job Application Closing Date</label>
                                                                                <input type="date" required name="Job_Last_application_date" value="<?php echo $jobs->Job_Last_application_date; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="">Job No Of Vacancies</label>
                                                                                <input type="number" required name="Job_No_of_vacancy" value="<?php echo $jobs->Job_No_of_vacancy; ?>" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="exampleInputPassword1">Job Description</label>
                                                                                <textarea name="Job_description" rows="5" class="form-control"><?php echo $jobs->Job_description; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="submit" name="update_job" class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete-<?php echo $jobs->Job_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Delete <?php echo $jobs->Job_title; ?> ?</h4>
                                                                <br>
                                                                <p>Heads Up, You are about to delete <?php echo $jobs->Job_title; ?>. This action is irrevisble.</p>
                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                <a href="jobs?delete=<?php echo $jobs->Job_id; ?>" class="text-center btn btn-danger"> Delete </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>
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