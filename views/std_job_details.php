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

/* Apply Job  */
if (isset($_POST['Apply_Job'])) {
    $Application_Date = date('d M Y');
    $Application_Student_id = $_POST['Application_Student_id'];
    $Application_Job_id = $_POST['Application_Job_id'];
    /* Prevent Multiple Applications */
    $sql = "SELECT * FROM  applications WHERE Application_Student_id = '$Application_Student_id' AND  Application_Job_id = '$Application_Job_id'     ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($Application_Job_id == $row['Application_Job_id'] && $Application_Student_id == $row['Application_Student_id']) {
            $err =  "You Have Already Applied This Job";
        }
    } else {
        $query = "INSERT INTO applications  (Application_Date, Application_Student_id, Application_Job_id) VALUES(?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sss', $Application_Date, $Application_Student_id, $Application_Job_id);
        $stmt->execute();

        if ($stmt) {
            $success = "Job Application Request Submitted";
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
        $ret =
            "SELECT * FROM job j INNER JOIN company c ON c.Company_id = j.Job_Company_id 
            WHERE j.Job_id = '$view'
        ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($job = $res->fetch_object()) {
        ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Job & Hiring Company Details</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="std_home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="std_home">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Job Details</li>
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

                                        <h3 class="profile-username text-center"><?php echo $job->Company_name; ?></h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Contacts:</b> <a class="float-right"><?php echo $job->Company_contact; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $job->Company_email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Website:</b> <a class="float-right"><?php echo $job->Company_website; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Location:</b> <a class="float-right"><?php echo $job->Company_location; ?></a>
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
                                            <li class="nav-item"><a class="nav-link active" href="#add_job" data-toggle="tab">Job Details</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#apply_job" data-toggle="tab">Job Application</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane active" id="add_job">
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Job Title:</b> <a class="float-right"><?php echo $job->Job_title; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Job Category: </b> <a class="float-right"><?php echo $job->Job_Category; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Job Location:</b> <a class="float-right"><?php echo $job->Job_location; ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Applications Closing Date:</b> <a class="float-right"><?php echo date('d M Y', strtotime($job->Job_Last_application_date)); ?></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Vacancies:</b> <a class="float-right"><?php echo $job->Job_No_of_vacancy; ?></a>
                                                    </li>
                                                </ul>
                                                <h4 class="text-center">Job Description</h4>
                                                <p>
                                                    <?php echo $job->Job_description; ?>
                                                </p>
                                            </div>

                                            <div class="tab-pane" id="apply_job">
                                                <p class="text-center text-danger">
                                                    If you feel that you are up to the challenge and possess the necessary qualification and experience,
                                                    please click the below button to submit your job application
                                                </p>
                                                <div class="text-center">
                                                    <a href="apply" data-toggle="modal" class="btn btn-outline-success"><i class="fas fa-file-signature"></i>Apply This Job</a>
                                                </div>
                                                <!-- Application Modal -->
                                                <div class="modal fade" id="apply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">CONFIRM APPLICATION</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center text-danger">
                                                                <h4>Submit Your Job Application For This Job?</h4>
                                                                <br>
                                                                <form method="post">
                                                                    <?php
                                                                    $Login_id = $_SESSION['Login_id'];
                                                                    $ret = "SELECT * FROM student WHERE Student_Login_id = '$Login_id' ";
                                                                    $stmt = $mysqli->prepare($ret);
                                                                    $stmt->execute(); //ok
                                                                    $res = $stmt->get_result();
                                                                    while ($student = $res->fetch_object()) {
                                                                    ?>
                                                                        <input type="hidden" name="Application_Student_id" value="<?php echo $student->Student_Id; ?>">
                                                                    <?php
                                                                    } ?>
                                                                    <input type="hidden" name="Application_Job_id" value="<?php echo $job->Job_id; ?>">
                                                                    <button type="button" class="text-center btn btn-danger" data-dismiss="modal">No</button>
                                                                    <button type="submit" class="text-center btn btn-success" name="Apply_Job">Yes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Applicaion Modal -->
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