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
if (isset($_POST['Confirm_Password'])) {

    $Login_username  = $_SESSION['Login_username'];
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));
    /* Check If Passwords Match */
    if ($new_password != $confirm_password) {
        /* Die */
        $err = "Passwords Does Not Match";
    } else {
        /* Update Password */
        $query = "UPDATE login  SET  Login_password =? WHERE  Login_username = ? ";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc = $stmt->bind_param('ss',  $confirm_password, $Login_username);
        $stmt->execute();
        if ($stmt) {
            $success = "Password Reset" && header("refresh:1; url=index");
        } else {
            $err = "Password Reset Failed";
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
                <p class="login-box-msg">Enter login username to reset password</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="password" name="new_password" class="form-control" placeholder="New Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" name="Confirm_Password" class="btn btn-primary btn-block">Confirm Password</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php require_once('../partials/scripts.php'); ?>

</body>

</html>