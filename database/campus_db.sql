-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 21, 2021 at 12:49 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_id` int(11) NOT NULL,
  `Admin_full_name` varchar(50) NOT NULL,
  `Admin_contact` varchar(50) NOT NULL,
  `Admin_email` varchar(50) NOT NULL,
  `Admin_username` varchar(50) NOT NULL,
  `Admin_password` varchar(50) NOT NULL,
  `Admin_Login_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_id`, `Admin_full_name`, `Admin_contact`, `Admin_email`, `Admin_username`, `Admin_password`, `Admin_Login_id`) VALUES
(1, 'System Administrator', '0712345678', 'sysadmin@jpms.com', 'sysadmin', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'fea4505fd3c994f5683f');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `Application_id` int(11) NOT NULL,
  `Application_Date` varchar(100) NOT NULL,
  `Application_Student_id` int(11) NOT NULL,
  `Application_Job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`Application_id`, `Application_Date`, `Application_Student_id`, `Application_Job_id`) VALUES
(1, '07/20/2021', 1, 1),
(4, '21 Jul 2021', 6, 1),
(5, '21 Jul 2021', 6, 5),
(6, '21 Jul 2021', 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Company_id` int(11) NOT NULL,
  `Company_name` varchar(100) NOT NULL,
  `Company_location` varchar(100) NOT NULL,
  `Company_contact` varchar(50) NOT NULL,
  `Company_email` varchar(50) NOT NULL,
  `Company_Category_id` int(50) NOT NULL,
  `Company_website` varchar(50) NOT NULL,
  `company_login_id` varchar(200) NOT NULL,
  `company_account_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`Company_id`, `Company_name`, `Company_location`, `Company_contact`, `Company_email`, `Company_Category_id`, `Company_website`, `company_login_id`, `company_account_status`) VALUES
(1, 'Tech Savanna', '127 Localhost', '+254900933124', 'mail@techsavanna.org', 1, 'techsavanna.org', 'e12d5fa22e77b909651dd836ec7c372d0e73196b33', 'Approved'),
(4, 'Gelian Hotel', '127 Machakos.', '+125900924', 'hello@gelian.com', 3, 'gelian.com', '0c0fa9f6f86f9b325af1d2b5e2629dc7d3abcfc552', 'Approved'),
(5, 'Dynasoft Inc', '901276 Nairobi', '+9012578634', 'hello@dynasoft.inc', 1, 'dynasoft.inc', '8438bd3198740b57b4757ba33e11df60745b9179cf', 'Approved'),
(7, 'Devlan Inc Technologies', '90127 Localhost', '+254737229776', 'mail@devlan.com', 1, 'devlan.com', '5b00ff374b251443d55ec43ace255355c13f63f803', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `company_categories`
--

CREATE TABLE `company_categories` (
  `Category_id` int(11) NOT NULL,
  `Category_name` varchar(100) NOT NULL,
  `Category_desc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_categories`
--

INSERT INTO `company_categories` (`Category_id`, `Category_name`, `Category_desc`) VALUES
(1, 'Information Communication Technology', 'Information Communication Technology is a company sector that deals with technology, information and communicated related products.'),
(3, 'Hospitality', 'Hospitality category houses all companies that are in Hospitality industry.');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `Job_id` int(11) NOT NULL,
  `Job_title` varchar(50) NOT NULL,
  `Job_Category` varchar(50) NOT NULL,
  `Job_description` longtext NOT NULL,
  `Job_location` varchar(50) NOT NULL,
  `Job_Company_id` int(11) NOT NULL,
  `Job_apply_date` varchar(200) DEFAULT NULL,
  `Job_Last_application_date` varchar(200) DEFAULT NULL,
  `Job_No_of_vacancy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`Job_id`, `Job_title`, `Job_Category`, `Job_description`, `Job_location`, `Job_Company_id`, `Job_apply_date`, `Job_Last_application_date`, `Job_No_of_vacancy`) VALUES
(1, 'Software Engineer', 'Entry Level', 'Tech Savanna is looking for an entry level full stack software engineer.', 'Nairobi', 1, '2021-07-20', '2021-08-03', 2),
(3, 'Hotel Manager', 'Managerial', 'Gelian Group Of Hotels is looking ahead to hire a talented manager.', 'Machakos', 4, '2021-07-20', '2021-08-03', 1),
(5, 'UI/UX Designer', 'Middle Level', 'Tech Savanna is looking for an experienced UI/UX Designer to join their team.', 'Nairobi', 1, '2021-07-20', '2021-08-03', 2),
(7, 'Web / App Developer', 'Mid Level', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nisl nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit. Aliquam eleifend mi in nulla posuere sollicitudin aliquam. Faucibus purus in massa tempor. Consectetur adipiscing elit duis tristique sollicitudin nibh sit amet. Eget aliquet nibh praesent tristique magna. Mauris nunc congue nisi vitae. Sit amet est placerat in. Imperdiet nulla malesuada pellentesque elit. Nisi vitae suscipit tellus mauris a. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Elementum tempus egestas sed sed risus pretium quam. Id eu nisl nunc mi ipsum faucibus vitae aliquet nec. Eu lobortis elementum nibh tellus molestie nunc non. At varius vel pharetra vel turpis nunc eget lorem dolor. Nunc eget lorem dolor sed viverra ipsum nunc aliquet.\r\n\r\nTortor posuere ac ut consequat semper viverra nam libero. Id eu nisl nunc mi ipsum faucibus vitae aliquet. Luctus venenatis lectus magna fringilla urna porttitor. Nec sagittis aliquam malesuada bibendum arcu. Sapien faucibus et molestie ac feugiat sed lectus vestibulum mattis. Morbi tristique senectus et netus et malesuada fames ac. Mauris a diam maecenas sed enim. Orci a scelerisque purus semper eget. Congue nisi vitae suscipit tellus mauris a diam maecenas sed. Ligula ullamcorper malesuada proin libero. Adipiscing tristique risus nec feugiat in fermentum. Diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque.', 'Remote', 5, '2021-07-21', '2021-08-04', 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `Login_id` varchar(200) NOT NULL,
  `Login_username` varchar(50) NOT NULL,
  `Login_password` varchar(50) NOT NULL,
  `Login_rank` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Login_id`, `Login_username`, `Login_password`, `Login_rank`) VALUES
('0c0fa9f6f86f9b325af1d2b5e2629dc7d3abcfc552', 'Gelian Hotels', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
('1bb387e60744d32059c1cd1f716e337d8a868b793a', 'dj120@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('203510332579cc786b976991204ff2787c7d7ed302', 'annamontana@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('380abc865b14efc50064f2ee036207800f0453c4be', 'janedoe@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('5b00ff374b251443d55ec43ace255355c13f63f803', 'login@devlan.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
('67c76a313610f27a26b64ab61f59b64dc1490761de', 'jamesdoe@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('8438bd3198740b57b4757ba33e11df60745b9179cf', 'Dynasoft Technologies', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
('ae57b369fddac114a075a90939dbf7ef332d69ea16', 'jamesfdoe@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('cc24ede799a3758c71c928c95b3cd3917e88801a43', 'jobdoe@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('e12d5fa22e77b909651dd836ec7c372d0e73196b33', 'Tech Savanna', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
('fea4505fd3c994f5683f', 'System Administrator', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `shortlisting`
--

CREATE TABLE `shortlisting` (
  `Shortlisting_id` int(11) NOT NULL,
  `Shortlisting_Date` varchar(200) NOT NULL,
  `Shortlisting_Application_id` int(11) NOT NULL,
  `Shortlisting_Login_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shortlisting`
--

INSERT INTO `shortlisting` (`Shortlisting_id`, `Shortlisting_Date`, `Shortlisting_Application_id`, `Shortlisting_Login_id`) VALUES
(2, '20 Jul 2021', 1, 'fea4505fd3c994f5683f'),
(4, '21 Jul 2021', 4, 'e12d5fa22e77b909651dd836ec7c372d0e73196b33'),
(5, '21 Jul 2021', 5, 'e12d5fa22e77b909651dd836ec7c372d0e73196b33');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_Id` int(11) NOT NULL,
  `Student_Full_Name` varchar(50) DEFAULT NULL,
  `Student_ID_Passport` varchar(50) DEFAULT NULL,
  `Student_Gender` varchar(50) DEFAULT NULL,
  `Student_DOB` varchar(50) DEFAULT NULL,
  `Student_Nationality` varchar(50) DEFAULT NULL,
  `Student_location` varchar(50) DEFAULT NULL,
  `Student_Contacts` varchar(50) DEFAULT NULL,
  `Student_Email` varchar(50) DEFAULT NULL,
  `Student_Highest_educational_attainment` varchar(50) DEFAULT NULL,
  `Student_Login_id` varchar(200) DEFAULT NULL,
  `student_Documents` longtext DEFAULT NULL,
  `student_CV` longtext DEFAULT NULL,
  `Student_account_status` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_Id`, `Student_Full_Name`, `Student_ID_Passport`, `Student_Gender`, `Student_DOB`, `Student_Nationality`, `Student_location`, `Student_Contacts`, `Student_Email`, `Student_Highest_educational_attainment`, `Student_Login_id`, `student_Documents`, `student_CV`, `Student_account_status`) VALUES
(1, 'Anna Montana', '39086543', 'Female', '1999-12-31', 'Kenya', 'Nairobi', '0712345678', 'annamontana@mail.com', 'Tertiary', '203510332579cc786b976991204ff2787c7d7ed302', NULL, NULL, 'Approved'),
(2, 'James Doe', '90126001', 'Male', '1990-12-12', 'Kenya', 'Kisumu', '07129082313', 'jamesdoe@mail.com', 'Tertiary', '67c76a313610f27a26b64ab61f59b64dc1490761de', '1626781930dummy.pdf', '1626781930dummy.pdf', 'Approved'),
(3, 'Janet Doe', '900125648', 'Female', '1990-12-09', 'Uganda', 'Nairobi', '+254723456789', 'janedoe@mail.com', 'Tertiary', '380abc865b14efc50064f2ee036207800f0453c4be', '1626781930dummy.pdf', '1626781930dummy.pdf', 'Approved'),
(4, 'Doe Jackson', '90125477', 'Male', '1980-12-12', 'Kenyan', 'Nairobi', '+254900123456', 'dj120@mail.com', 'Tertiary', '1bb387e60744d32059c1cd1f716e337d8a868b793a', '1626853616dummy.pdf', '1626853616dummy.pdf', 'Approved'),
(5, 'James F Doe', '901267653412', 'Male', '1998-12-12', 'Uganda', 'Kampala', '+25312907452', 'jamesfdoe@mail.com', 'Tertiary', 'ae57b369fddac114a075a90939dbf7ef332d69ea16', '1626855156dummy.pdf', '1626855156dummy.pdf', 'Approved'),
(6, 'Job Doe', '1270019023', 'Male', '1990-12-12', 'Kenya', 'Mombasa', '+25471234567', 'jobdoe@mail.com', 'Tertiary', 'cc24ede799a3758c71c928c95b3cd3917e88801a43', '1626863318dummy.pdf', '1626863318dummy.pdf', 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_id`),
  ADD KEY `Login_id` (`Admin_Login_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`Application_id`),
  ADD KEY `job_id` (`Application_Job_id`),
  ADD KEY `Application_Student_id` (`Application_Student_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Company_id`),
  ADD UNIQUE KEY `company_login_id` (`company_login_id`),
  ADD KEY `Category_id` (`Company_Category_id`);

--
-- Indexes for table `company_categories`
--
ALTER TABLE `company_categories`
  ADD PRIMARY KEY (`Category_id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`Job_id`),
  ADD KEY `company_id` (`Job_Company_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`Login_id`);

--
-- Indexes for table `shortlisting`
--
ALTER TABLE `shortlisting`
  ADD PRIMARY KEY (`Shortlisting_id`),
  ADD KEY `applicantion_id` (`Shortlisting_Application_id`),
  ADD KEY `Shortlisting_Login_id` (`Shortlisting_Login_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_Id`),
  ADD KEY `Student_Login_id` (`Student_Login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `Application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `Company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `company_categories`
--
ALTER TABLE `company_categories`
  MODIFY `Category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `Job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shortlisting`
--
ALTER TABLE `shortlisting`
  MODIFY `Shortlisting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
