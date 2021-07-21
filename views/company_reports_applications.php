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
require_once('../config/codeGen.php');
checklogin();
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
                            <h1 class="m-0 text-bold">Job Applications Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="company_home">Home</a></li>
                                <li class="breadcrumb-item"><a href="company_home">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="company_home">Reports</a></li>
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
                            <table id="report" class="table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Details</th>
                                        <th>Company Details</th>
                                        <th>Applicant Details</th>
                                        <th>Application Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $login = $_SESSION['Login_id'];
                                    $ret =
                                        "SELECT * FROM applications A
                                    INNER JOIN job J ON A.Application_Job_id = J.Job_id 
                                    INNER JOIN company C ON C.Company_id = J.Job_Company_id 
                                    INNER JOIN student S ON S.Student_Id = A.Application_Student_id
                                    WHERE C.company_login_id = '$login'
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