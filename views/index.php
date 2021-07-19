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

if (isset($_POST['Login'])) {
    $Login_username = $_POST['Login_username'];
    $Login_password = sha1(md5($_POST['Login_password']));

    $stmt = $mysqli->prepare("SELECT Login_username, Login_password, Login_rank, Login_id  FROM Login  WHERE Login_username =? AND Login_password =? AND Login_rank =?");
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
        header("location:student_dasboard");
    } else {
        $err = "Login Failed, Please Check Your Credentials And Login Permission ";
    }
}
