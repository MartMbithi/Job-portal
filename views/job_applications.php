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

/* Delete Job Application Category */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM applications WHERE Application_id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=job_applications");
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Shortlist Candidate */
if (isset($_GET['shortlist'])) {
    $Shortlisting_Application_id = $_GET['shortlist'];
    $Shortlisting_Date = date('d M Y');
    $Shortlisting_Login_id = $_SESSION['Login_id'];

    $adn = "INSERT INTO  shortlisting (Shortlisting_Date, Shortlisting_Application_id, Shortlisting_Login_id) VALUES(?,?,?)";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('sss', $Shortlisting_Date, $Shortlisting_Application_id, $Shortlisting_Login_id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Shortlisted" && header("refresh:1; url=job_applications");
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
                            <h1 class="m-0 text-bold">Job Applications</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Jobs Applications</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Details</th>
                                        <th>Company Details</th>
                                        <th>Applicant Details</th>
                                        <th>Application Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret =
                                        "SELECT * FROM applications A
                                    INNER JOIN job J ON A.Application_Job_id = J.Job_id 
                                    INNER JOIN company C ON C.Company_id = J.Job_Company_id 
                                    INNER JOIN student S ON S.Student_Id = A.Application_Student_id
                                    ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($applications = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td>
                                                Title: <?php echo $applications->Job_title; ?><br>
                                                Category: <?php echo $applications->Job_Category; ?><br>
                                                Location: <?php echo $applications->Job_location; ?>
                                            </td>
                                            <td>
                                                Name: <?php echo $applications->Company_name; ?><br>
                                                Location: <?php echo $applications->Company_location; ?><br>
                                                Contact : <?php echo $applications->Company_contact; ?><br>
                                                Email : <?php echo $applications->Company_email; ?>
                                            </td>
                                            <td>
                                                Name: <?php echo $applications->Student_Full_Name; ?><br>
                                                Phone: <?php echo $applications->Student_Contacts; ?><br>
                                                Email: <?php echo $applications->Student_Email; ?><br>
                                                Location : <?php echo $applications->Student_location; ?><br>
                                                Nationality: <?php echo $applications->Student_Nationality; ?>
                                            </td>
                                            <td>
                                                Application Date: <?php echo date('d M Y', strtotime($applications->Application_Date)); ?><br>
                                            </td>
                                            <td>
                                                <a class="badge badge-success" data-toggle="modal" href="#shortlist-<?php echo $applications->Application_id; ?>">
                                                    <i class="fas fa-user-check"></i>
                                                    Shortlist
                                                </a>

                                                <a class="badge badge-danger" data-toggle="modal" href="#delete-<?php echo $applications->Application_id; ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>

                                                <!-- Shortlist Applicant -->
                                                <div class="modal fade" id="shortlist-<?php echo $applications->Application_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">CONFIRM SHORTLISTING</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Shortlist <?php echo $applications->Student_Full_Name; ?>?</h4>
                                                                <br>
                                                                <p>Heads Up, You are about to shortlist the above candidate.</p>
                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                <a href="job_applications?shortlist=<?php echo $applications->Application_id; ?>" class="text-center btn btn-danger"> Short List </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Shortlist -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete-<?php echo $applications->Application_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Delete?</h4>
                                                                <br>
                                                                <p>Heads Up, You are about to delete this job application. This action is irrevisble.</p>
                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                <a href="job_applications?delete=<?php echo $applications->Application_id; ?>" class="text-center btn btn-danger"> Delete </a>
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