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

$Login = $_SESSION['Login_id'];
$ret = "SELECT * FROM student WHERE Student_Login_id = '$Login' ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($std = $res->fetch_object()) {

    /* Job Applications */
    $query = "SELECT COUNT(*)  FROM `applications` WHERE Application_Student_id = '$std->Student_Id' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($applications);
    $stmt->fetch();
    $stmt->close();

    /* Shortlisted Applications */
    $query =
        "SELECT COUNT(*)  FROM 
        student s INNER JOIN applications A
        ON A.Application_Student_id = s.Student_Id 
        INNER JOIN shortlisting S
        ON S.Shortlisting_Application_id = A.Application_id
        WHERE s.Student_id ='$std->Student_Id'  ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($shortlisted);
    $stmt->fetch();
    $stmt->close();
}
/* Posted Jobs */
$query = "SELECT COUNT(*)  FROM `job` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($posted_jobs);
$stmt->fetch();
$stmt->close();
