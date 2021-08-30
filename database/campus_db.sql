-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 30, 2021 at 01:36 PM
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
(5, 'Dynasoft Inc', '901276 Nairobi', '+9012578634', 'hello@dynasoft.inc', 1, 'dynasoft.inc', '8438bd3198740b57b4757ba33e11df60745b9179cf', 'Approved'),
(7, 'Devlan Inc Technologies', '90127 Localhost', '+254737229776', 'mail@devlan.com', 1, 'devlan.com', '5b00ff374b251443d55ec43ace255355c13f63f803', 'Approved'),
(8, 'Martdevelopers Inc', 'Machakos - Kenya', '0710090126', 'mail@martdevelopers.inc', 1, 'martdevelopers.com', '95c1d96966ef2ec4ce98717e96b2dac645a7743c6a', 'Approved'),
(9, 'Softonic Technologies', '90126 Localhost', '90126', 'mail@softonic.com', 1, 'softonic.com', '9f76719088af35118f249ae3afe82e53e17dd5d772', 'Approved');

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
(3, 'Hotel Manager', 'Managerial', 'Gelian Group Of Hotels is looking ahead to hire a talented manager.', 'Machakos', 4, '2021-07-20', '2021-08-03', 1);

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
('5b00ff374b251443d55ec43ace255355c13f63f803', 'login@devlan.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
('82405fb766dbcd2bc5029e4c2184bad2c0bf552a2f', 'jamesdpe@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Student'),
('8438bd3198740b57b4757ba33e11df60745b9179cf', 'Dynasoft Technologies', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
('9f76719088af35118f249ae3afe82e53e17dd5d772', 'softonic', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Company'),
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
(8, 'James Doe', '901002991', 'Male', '2021-08-30', 'Kenyan', 'Nairobi', '90012674', 'jamesdpe@mail.com', 'Tertiary', '82405fb766dbcd2bc5029e4c2184bad2c0bf552a2f', '1630323225dummy.pdf', '1630323225dummy.pdf', 'Approved');

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
  MODIFY `Company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `Student_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
