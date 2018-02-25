-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2018 at 10:23 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exptracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`CategoryID`, `CategoryName`) VALUES
(1, 'Food'),
(2, 'Grocery'),
(3, 'Entertainment'),
(4, 'Vehicle'),
(5, 'Miscellaneous'),
(6, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tblexpense`
--

CREATE TABLE `tblexpense` (
  `ExpenseID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Amount` double NOT NULL,
  `Date` datetime NOT NULL,
  `Place` varchar(250) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblexpense`
--

INSERT INTO `tblexpense` (`ExpenseID`, `Name`, `Description`, `CategoryID`, `Amount`, `Date`, `Place`, `UserID`) VALUES
(1, 'Lunch', 'Lunch at College', 1, 33, '2018-02-24 00:00:00', 'DAIICT', 1),
(2, 'Dinner', 'At College', 1, 33, '2018-02-24 00:00:00', 'DAIICT', 1),
(7, 'Soap', 'Washing Soap', 2, 54, '2018-02-25 00:00:00', 'Umiya Store', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`UserID`, `Name`, `Email`, `Password`, `IsActive`) VALUES
(1, 'Ritesh', 'rdtailor@gmail.com', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `tblexpense`
--
ALTER TABLE `tblexpense`
  ADD PRIMARY KEY (`ExpenseID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tblexpense`
--
ALTER TABLE `tblexpense`
  MODIFY `ExpenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
