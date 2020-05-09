-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2020 at 03:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yinlian_pessdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dispatch`
--

CREATE TABLE `dispatch` (
  `incidentld` int(11) NOT NULL,
  `patrolcarId` varchar(10) CHARACTER SET latin1 NOT NULL,
  `timeDispatched` datetime NOT NULL,
  `timeArrived` datetime DEFAULT NULL,
  `timeCompleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dispatch`
--

INSERT INTO `dispatch` (`incidentld`, `patrolcarId`, `timeDispatched`, `timeArrived`, `timeCompleted`) VALUES
(27, 'QX1111J', '2020-05-09 18:49:11', '2020-05-09 19:55:44', '2020-05-09 20:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `incidentld` int(11) NOT NULL,
  `callerName` varchar(30) CHARACTER SET latin1 NOT NULL,
  `phoneNumber` varchar(10) CHARACTER SET latin1 NOT NULL,
  `incidentTypeId` varchar(3) CHARACTER SET latin1 NOT NULL,
  `incidentLocation` varchar(50) CHARACTER SET latin1 NOT NULL,
  `incidentDesc` varchar(100) CHARACTER SET latin1 NOT NULL,
  `incidentStatusId` varchar(1) CHARACTER SET latin1 NOT NULL,
  `timeCalled` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`incidentld`, `callerName`, `phoneNumber`, `incidentTypeId`, `incidentLocation`, `incidentDesc`, `incidentStatusId`, `timeCalled`) VALUES
(27, 'Emilia Toh', '91234567', '010', 'ITE College Central', 'There is a fire breakout in the school.', '2', '2020-05-09 10:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `incidenttype`
--

CREATE TABLE `incidenttype` (
  `incidentTypeId` varchar(3) CHARACTER SET latin1 NOT NULL,
  `incidentTypeDesc` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incidenttype`
--

INSERT INTO `incidenttype` (`incidentTypeId`, `incidentTypeDesc`) VALUES
('010', 'Fire'),
('020', 'Riot'),
('030', 'Burglary'),
('040', 'Domestic Violent'),
('050', 'Fallen Tree'),
('060', 'Traffic Accident'),
('070', 'Loan Shark'),
('999', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `incident_status`
--

CREATE TABLE `incident_status` (
  `statusId` varchar(1) CHARACTER SET latin1 NOT NULL,
  `statusDesc` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_status`
--

INSERT INTO `incident_status` (`statusId`, `statusDesc`) VALUES
('1', 'Pending'),
('2', 'Dispatched'),
('3', 'Completed'),
('4', 'Duplicate');

-- --------------------------------------------------------

--
-- Table structure for table `patrolcar`
--

CREATE TABLE `patrolcar` (
  `patrolcarId` varchar(10) CHARACTER SET latin1 NOT NULL,
  `patrolcarStatusId` varchar(1) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patrolcar`
--

INSERT INTO `patrolcar` (`patrolcarId`, `patrolcarStatusId`) VALUES
('QX1111J', '3'),
('QX1234A', '3'),
('QX1342G', '4'),
('QX2222K', '3'),
('QX2288D', '1'),
('QX3456B', '1'),
('QX5555D', '4'),
('QX8723W', '4'),
('QX8769P', '4'),
('QX8923T', '1');

-- --------------------------------------------------------

--
-- Table structure for table `patrolcar_status`
--

CREATE TABLE `patrolcar_status` (
  `statusId` varchar(1) CHARACTER SET latin1 NOT NULL,
  `statusDesc` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patrolcar_status`
--

INSERT INTO `patrolcar_status` (`statusId`, `statusDesc`) VALUES
('1', 'Dispatched'),
('2', 'Patrol'),
('3', 'Free'),
('4', 'Arrived');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dispatch`
--
ALTER TABLE `dispatch`
  ADD PRIMARY KEY (`incidentld`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`incidentld`);

--
-- Indexes for table `incidenttype`
--
ALTER TABLE `incidenttype`
  ADD PRIMARY KEY (`incidentTypeId`);

--
-- Indexes for table `incident_status`
--
ALTER TABLE `incident_status`
  ADD PRIMARY KEY (`statusId`);

--
-- Indexes for table `patrolcar`
--
ALTER TABLE `patrolcar`
  ADD PRIMARY KEY (`patrolcarId`);

--
-- Indexes for table `patrolcar_status`
--
ALTER TABLE `patrolcar_status`
  ADD PRIMARY KEY (`statusId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `incidentld` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
