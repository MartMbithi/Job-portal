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


/* Company Categories */
$query = "SELECT COUNT(*)  FROM `company_categories` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($company_categrories);
$stmt->fetch();
$stmt->close();

/* Companies */
$query = "SELECT COUNT(*)  FROM `company` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($companies);
$stmt->fetch();
$stmt->close();

/* Posted Jobs */
$query = "SELECT COUNT(*)  FROM `job` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($jobs);
$stmt->fetch();
$stmt->close();

/* Students */
$query = "SELECT COUNT(*)  FROM `student` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($students);
$stmt->fetch();
$stmt->close();
