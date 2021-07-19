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

if (isset($_POST['Sign_Up'])) {
    $Student_Full_Name = $_POST['Student_Full_Name'];
    $Student_ID_Passport = $_POST['Student_ID_Passport'];
    $Student_Gender = $_POST['Student_Gender'];
    $Student_DOB = $_POST['Student_DOB'];
    $Student_Email = $_POST['Student_Email'];
    $Student_Contacts = $_POST['Student_Contacts'];

    /* Login Details */
    $Login_rank = 'Student';
    $Login_id = $_POST['Login_id'];
    $Login_password = sha1(md5($_POST['Login_password']));

    $query = "INSERT INTO student (Student_Full_Name, Student_ID_Passport, Student_Gender, Student_DOB, Student_Contacts, Student_Email, Student_Login_id) VALUES(?,?,?,?,?,?,?)";
    $auth = "INSERT INTO login (Login_id, Login_username, Login_password, Login_rank) VALUES(?,?,?,?)";

    $stmt = $mysqli->prepare($query);
    $auth_stmt = $mysqli->prepare($auth);

    $rc = $stmt->bind_param('sssssss', $Student_Full_Name, $Student_ID_Passport, $Student_Gender, $Student_DOB, $Student_Contacts, $Student_Email, $Login_id);
    $rc = $auth_stmt->bind_param('ssss', $Login_id, $Student_Email, $Login_password, $Login_rank);

    $stmt->execute();
    $auth_stmt->execute();

    if ($stmt && $auth_stmt) {
        $success = "$Student_Full_Name Account Created.";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}
require_once('../partials/head.php');
?>

<body class="hold-transition login-page">
    <div class="">
        <div class="login-logo">
            <a href=""><b>Job Portal Management System - Sign Up </b></a>
        </div>
        <div class="card">
            <div class="card-body">
                <form role="form" method="POST">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" required name="Student_Full_Name" class="form-control">
                        <input type="hidden" required name="Login_id" value="<?php echo $sys_gen_id; ?>" class="form-control">
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">Id / Passport No</label>
                            <input type="text" required name="Student_ID_Passport" class="form-control">
                        </div>
                        <div class="form-group col-4">
                            <label for="">Gender</label>
                            <select type="text" required name="Student_Gender" class="form-control">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label for="">Date Of Birth</label>
                            <input type="text" placeholder="DD/MM/YYY" required name="Student_DOB" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">Contacts</label>
                            <input type="text" required name="Student_Contacts" class="form-control">
                        </div>
                        <div class="form-group col-4">
                            <label for="">Email</label>
                            <input type="text" required name="Student_Email" class="form-control">
                        </div>
                        <div class="form-group col-4">
                            <label for="">Password</label>
                            <input type="password" required name="Login_password" class="form-control">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" name="Sign_Up" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forget_password">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="index" class="text-center">Sign In</a>
                </p>
            </div>
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>

</body>

</html>