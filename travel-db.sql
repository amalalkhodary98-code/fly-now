

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `travel_time` time DEFAULT NULL,
  `trip_type` varchar(20) DEFAULT NULL,
  `class_type` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `seat` varchar(50) DEFAULT NULL,
  `bags` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'قيد المراجعة',
  `phone` varchar(20) DEFAULT NULL,
  `seen` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `bookings` (`id`, `flight_id`, `name`, `travel_date`, `travel_time`, `trip_type`, `class_type`, `user_id`, `seat`, `bags`, `payment_method`, `status`, `phone`, `seen`) VALUES
(57, 147, 'امل الخضري', '2026-05-14', '17:00:00', 'ذهاب وعودة', 'أولى', 1, 'A1', '2', 'Apple Pay', 'تم التأكيد', '0597898540', 0),
(58, 142, 'امل الخضري', '2026-05-14', '22:39:00', 'ذهاب', 'سياحية', 1, 'A2', '1', 'MasterCard', 'تم التأكيد', '0597898540', 0),
(59, 162, 'امل الخضري', '2026-06-10', '05:00:00', 'ذهاب وعودة', 'أولى', 1, 'A1', '1', 'Visa', 'تم التأكيد', '0597898540', 0),
(60, 183, 'سالي كنعان الخضري', '0000-00-00', '12:00:00', 'ذهاب', 'سياحية', 1, 'A2', '1', 'MasterCard', 'تم التأكيد', '0597898540', 0),
(61, 184, 'امل الخضري', '2026-05-12', '12:00:00', 'ذهاب', 'سياحية', 1, 'A1', '1', 'Visa', 'قيد المراجعة', '0599999999', 0);


CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`, `subject`) VALUES
(1, 'Amal Alkhodary', 'amalalkhodary98@gmail.com', 'يرجي التواصل معنا بكل التفاصيل ', '2026-07-05 13:42:46', 'الغاء حجز تم اعتماده');


CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `from_city` varchar(100) DEFAULT NULL,
  `to_city` varchar(100) DEFAULT NULL,
  `departure_time` datetime DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `seats` int(50) NOT NULL,
  `airline` varchar(100) DEFAULT NULL,
  `from_airport` varchar(100) DEFAULT NULL,
  `to_airport` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'On Time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `flights` (`id`, `from_city`, `to_city`, `departure_time`, `price`, `seats`, `airline`, `from_airport`, `to_airport`, `status`) VALUES
(183, 'Amman', 'Dubai', '2026-06-20 10:00:00', 320.00, 99, 'Emirates', 'Queen Alia', 'Dubai International', 'في الموعد'),
(184, 'Amman', 'Istanbul', '2026-07-15 01:30:00', 350.00, 119, 'Turkish Airlines', 'Queen Alia Airport', 'Istanbul Airport', 'متأخرة');


CREATE TABLE `gaza_requests` (
  `id` int(11) NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `request_status` varchar(100) DEFAULT 'قيد المراجعة',
  `travel_route` text DEFAULT NULL,
  `id_file` varchar(255) DEFAULT NULL,
  `passport_file` varchar(255) DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `travel_reason` varchar(100) DEFAULT NULL,
  `companions` varchar(50) DEFAULT NULL,
  `border_crossing` varchar(100) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `travel_time` time DEFAULT NULL,
  `injured` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `meeting_point` varchar(255) DEFAULT NULL,
  `departure_point` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `security_question`, `security_answer`, `phone`) VALUES
(1, 'Amal Alkhodary', 'amalalkhodary98@gmail.com', '1161995', 'user', NULL, NULL, NULL),
(3, 'Admin', 'admin@gmail.com', '8520', 'admin', NULL, NULL, NULL),
(5, 'سالي كنعان الخضري', 'Sally89alkhodari@gmail.com', '000000', 'user', NULL, NULL, NULL),
(6, 'دعاء شاهين', 'doaa90@gmaile.com', '7410', 'user', NULL, NULL, NULL),
(8, ' Rawan Zeen eldin', 'rawan99@gmail.com', '100200300', 'user', NULL, NULL, NULL),
(11, 'shaima Zeen eldein', 'shaimaa2000@gmile.com', '123456789', 'user', NULL, NULL, NULL);

ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gaza_requests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

ALTER TABLE `gaza_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;
