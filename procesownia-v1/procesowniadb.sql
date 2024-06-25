-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 25, 2024 at 03:25 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `procesowniadb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author_name`, `content`, `timestamp`) VALUES
(8, 18, 'Bartek', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consequat velit in sollicitudin venenatis. Vestibulum blandit suscipit erat, tempor luctus orci bibendum non. Proin augue lacus, aliquam ac nisi nec, pellentesque dignissim massa. Aliquam elementum euismod nibh, in vulputate sem vestibulum nec. Aliquam euismod ex ac lectus imperdiet accumsan. Nullam pharetra neque et erat hendrerit viverra. Integer aliquam, dolor luctus molestie efficitur, elit mi rhoncus orci, eu iaculis neque ex ac lacus. Sed ut hendrerit nisl. Vivamus lorem risus, venenatis gravida mollis ac, consequat nec sapien. Aliquam ut aliquet sapien. Nam vitae lorem tincidunt nisl porttitor sodales.', '2024-06-25 12:19:10');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `author_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author`, `content`, `image`, `timestamp`, `author_name`) VALUES
(18, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consequat velit in sollicitudin venenatis. Vestibulum blandit suscipit erat, tempor luctus orci bibendum non. Proin augue lacus, aliquam ac nisi nec, pellentesque dignissim massa. Aliquam elementum euismod nibh, in vulputate sem vestibulum nec. Aliquam euismod ex ac lectus imperdiet accumsan. Nullam pharetra neque et erat hendrerit viverra. Integer aliquam, dolor luctus molestie efficitur, elit mi rhoncus orci, eu iaculis neque ex ac lacus. Sed ut hendrerit nisl. Vivamus lorem risus, venenatis gravida mollis ac, consequat nec sapien. Aliquam ut aliquet sapien. Nam vitae lorem tincidunt nisl porttitor sodales.', '', '2024-06-25 12:19:06', 'Bartek');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `created_at`) VALUES
(5, '', '$2y$10$0PgfUCwpKszder3oYDoeq.gX52N20QKJGs9A7cNMOHV.n7T8GAg5i', 'ada@adad.fes', '2024-06-25 12:13:13'),
(6, 'Adam', '$2y$10$ILkFfo8MXs6qGGF4B80hb.Ve.HA/qGmwTQrhwnpN9RqyBjAnwrg3.', 'adam@adadm.com', '2024-06-25 12:14:55'),
(7, 'Bartek', '$2y$10$ZUMlArTKgf611hXKeVUrg.4zaQlckxajrOeHu2scNe7JjY/YJNNBK', 'bartek@bartek.com', '2024-06-25 12:15:15'),
(8, 'Stefan', '$2y$10$zUWay.oMhYQLZDf60aCFHe9.9.OF8D42HqjZhav1/manfe2kK6uiy', 'bartekmis2002@gmail.com', '2024-06-25 13:17:50');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
