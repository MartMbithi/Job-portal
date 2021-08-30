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
require_once('../config/codeGen.php');

/* Login */
if (isset($_POST['Login'])) {
    $Login_username = $_POST['Login_username'];
    $Login_password = sha1(md5($_POST['Login_password']));
    $Login_rank = $_POST['Login_rank'];

    $stmt = $mysqli->prepare("SELECT Login_username, Login_password, Login_rank, Login_id  FROM login  WHERE Login_username =? AND Login_password =?  AND Login_rank = ?");
    $stmt->bind_param('sss', $Login_username, $Login_password, $Login_rank);
    $stmt->execute(); //execute bind

    $stmt->bind_result($Login_username, $Login_password, $Login_rank, $Login_id);
    $rs = $stmt->fetch();
    $_SESSION['Login_id'] = $Login_id;
    $_SESSION['Login_rank'] = $Login_rank;

    /* Decide Login User Dashboard Based On User Rank */
    if ($rs && $Login_rank == 'Administrator') {
        header("location:home");
    } else if ($rs && $Login_rank == 'Student') {
        header("location:std_home");
    } else if ($rs && $Login_rank == 'Company') {
        header("location:company_home");
    } else {
        $err = "Login Failed, Please Check Your Credentials And Login Permission ";
    }
}

/* Sign Up As Student */
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

    $student_CV = time() . $_FILES['student_CV']['name'];
    move_uploaded_file($_FILES["student_CV"]["tmp_name"], "../public/uploads/" . $student_CV);

    $student_Documents =  time() . $_FILES['student_Documents']['name'];
    move_uploaded_file($_FILES["student_Documents"]["tmp_name"], "../public/uploads/"  . $student_Documents);


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
            $success = "$Student_Full_Name Account Created Proceed To Log In";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Sign Up As Company */
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
            $success = "$Company_name Account Created, Proceed To Login In";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}
require_once('../partials/head.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Job Portal Management System</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="Login_username" class="form-control" placeholder="Login Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="Login_password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-center">
                        Login In As
                    </p>


                    <div class="row">
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <select name="Login_rank" style="width: 100%;" class="form-control basic">
                                    <option>Administrator</option>
                                    <option>Company</option>
                                    <option>Student</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" name="Login" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forget_password">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a data-toggle="modal" href="#add_student_account" class="text-center">Register a student account</a>
                </p>
                <p class="mb-0">
                    <a data-toggle="modal" href="#add_company_account" class="text-center">Register a company account</a>
                </p>
            </div>
            <!-- Student Account Modal-->
            <div class="modal fade" id="add_student_account">
                <div class="modal-dialog  modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Sign Up As Student - Fill All Values</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" role="form">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Full Name</label>
                                            <input type="text" required name="Student_Full_Name" class="form-control">
                                            <input type="hidden" required name="Student_Login_id" value="<?php echo $sys_gen_id; ?>" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">ID / Passport Number</label>
                                            <input type="text" required name="Student_ID_Passport" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Gender</label>
                                            <select type="text" required name="Student_Gender" class="form-control">
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">D.O.B</label>
                                            <input type="date" required name="Student_DOB" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Nationality</label>
                                            <input type="text" required name="Student_Nationality" class="form-control">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Location</label>
                                            <input type="text" required name="Student_location" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Contacts</label>
                                            <input type="text" required name="Student_Contacts" class="form-control">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Email</label>
                                            <input type="email" required name="Student_Email" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Highest Education Level Attained</label>
                                            <select type="text" required name="Student_Highest_educational_attainment" class="form-control">
                                                <option>Primary School</option>
                                                <option>Secondary School</option>
                                                <option>Tertiary</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">CV</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" required accept=".docx, .pdf, .doc" name="student_CV" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label " for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Student Documents</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" required accept=".docx, .pdf, .doc" name="student_Documents" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label " for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Login Password</label>
                                            <input type="password" required name="Login_password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" name="add_student" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Student Account Modal -->

            <!-- Company Modal -->
            <div class="modal fade" id="add_company_account">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create A Company Account - Fill All Values </h4>
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
            <!-- End Company Modal -->
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>

</body>

</html>