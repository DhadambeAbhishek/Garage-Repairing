-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 05:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garage_repair`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookingsreq`
--

CREATE TABLE `bookingsreq` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_type` enum('Car','Bike') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Processing','Completed') DEFAULT 'Pending',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `mechanic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingsreq`
--

INSERT INTO `bookingsreq` (`id`, `user_id`, `vehicle_type`, `total_price`, `booking_date`, `status`, `name`, `email`, `phone`, `brand`, `model`, `mechanic_id`) VALUES
(2, 1, 'Bike', 0.00, '2025-02-19 03:25:34', 'Pending', '0', 'aditya123@gmail.com', '07972563609', 'bajaj', 'baj12o902ta', NULL),
(3, 1, 'Car', 1599.18, '2025-02-18 23:04:08', 'Completed', 'aditya', 'aditya123@gmail.com', '07972563609', 'bajaj', 'baj12o902ta', 4),
(4, 1, 'Bike', 799.59, '2025-02-18 23:59:24', 'Pending', 'aditya', 'aditya123@gmail.com', '07972563609', 'bajaj', 'baj12o902ta', NULL),
(5, 3, 'Car', 1050.00, '2025-02-19 09:25:53', 'Pending', 'raj', 'raj@gmail.com', '07745094459', 'AUDI', 'Audi102', NULL),
(6, 4, 'Bike', 599.59, '2025-03-03 01:03:21', 'Pending', 'ameya', 'ameya@gmail.com', '6767542387', 'splender', '2008', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_servicess`
--

CREATE TABLE `booking_servicess` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_servicess`
--

INSERT INTO `booking_servicess` (`id`, `booking_id`, `service_id`) VALUES
(1, 3, 1),
(2, 3, 1),
(3, 4, 1),
(4, 5, 4),
(5, 5, 5),
(6, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `part_type` enum('car','bike') NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `part_name`, `part_type`, `brand`, `model`, `material`, `quantity`) VALUES
(1, 'spring', 'bike', 'spender', '2008', 'asdfa', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mechanics`
--

CREATE TABLE `mechanics` (
  `mechanic_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `experience` text NOT NULL,
  `skill_rating` int(11) NOT NULL CHECK (`skill_rating` between 1 and 5),
  `resume` varchar(255) NOT NULL,
  `work_type` enum('Auto repairs','Diesel mechanics','Motorcycle repairs','Boat repairs','Aircraft repairs') NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `work_experience` text NOT NULL,
  `status` enum('Active','Working','Break') DEFAULT 'Active',
  `Mrole` enum('mechanic') DEFAULT 'mechanic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mechanics`
--

INSERT INTO `mechanics` (`mechanic_id`, `dob`, `phone`, `email`, `password`, `address`, `experience`, `skill_rating`, `resume`, `work_type`, `fullname`, `work_experience`, `status`, `Mrole`) VALUES
(4, '1979-02-16', '07745094576', 'john@gmail.com', '$2y$10$zHfb1HZ3y2VFnfgm8nyNEOZlnVUJjKh.qR/Ui5MQwi3ZvUVC/bt9K', 'Dighi,pune', 'good experience', 3, 'OIP.jpg', 'Auto repairs', 'John', 'Auto repairs', 'Active', 'mechanic'),
(5, '1998-06-10', '09511774509', 'jonathan@gmail.com', '$2y$10$aQa1sbMt6zX8Owt1mL/HpuDtXCecxQWm2jWLgtoNJjN.CwBmVI5KW', 'ganesh nager', 'good experience', 4, 'OIP.jpg', 'Auto repairs', 'jonathan', 'Motorcycle repairs', 'Working', 'mechanic');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `vehicle_type` enum('Bike','Car') NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `vehicle_type`, `service_name`, `price`) VALUES
(1, 'Bike', 'battery maintenance', 799.59),
(2, 'Bike', 'Oil changes', 599.59),
(3, 'Car', 'battery maintenance', 1000.87),
(4, 'Car', 'Wheel Alignment', 150.00),
(5, 'Car', 'Engine Diagnostics', 900.00),
(6, 'Car', 'Oil changes', 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'aditya', 'aditya123@gmail.com', '$2y$10$92tkPrkqoLby6/0K8FwA6OPJoyCqUufm6Nywfo45BiVv5ER9xDS6a', 'user'),
(2, 'admin', 'admin@gmail.com', '$2y$10$KFaflhPE4xSujyh6z7l9YOS4dOpTXuvA1l2181DIJLEnzN9gUwshC', 'admin'),
(3, 'raj', 'raj123@gmail.com', '$2y$10$h0cceBriUf/v1DKUxM/9F.lfWIM1zAXeRqITCRqZDFHc0QT.GDPhS', 'user'),
(4, 'ameya', 'ameya@gmail.com', '$2y$10$sSv5NWpUmYgaRCukJ0ZwA.gjXDacK5REG7ff5fYdgjIspm6JEDKhC', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingsreq`
--
ALTER TABLE `bookingsreq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `booking_servicess`
--
ALTER TABLE `booking_servicess`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mechanics`
--
ALTER TABLE `mechanics`
  ADD PRIMARY KEY (`mechanic_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookingsreq`
--
ALTER TABLE `bookingsreq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking_servicess`
--
ALTER TABLE `booking_servicess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mechanics`
--
ALTER TABLE `mechanics`
  MODIFY `mechanic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookingsreq`
--
ALTER TABLE `bookingsreq`
  ADD CONSTRAINT `bookingsreq_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_servicess`
--
ALTER TABLE `booking_servicess`
  ADD CONSTRAINT `booking_servicess_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookingsreq` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_servicess_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
