-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2024 at 07:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pencraft`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `post` varchar(10000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `tags` varchar(225) DEFAULT NULL,
  `cover` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `userid`, `post`, `date`, `description`, `title`, `tags`, `cover`) VALUES
(65, 7, 'bru3fb3r bru3fb3r bru3fb3r bru3fb3r bru3fb3r', '2024-04-22 16:43:16', 'red goes on an adventure ', 'reds adventure', 'adventure ', ''),
(67, 7, '3e', '2024-04-22 17:02:44', '3e', '3e', '3e', ''),
(97, 4, 'q', '2024-04-23 10:33:14', 'q', 'q', 'q', NULL),
(100, 4, 'yeah', '2024-04-23 10:38:59', 'about yourself', 'soul ', 'deep', 0x75706c6f6164732f63616e76612d62726f776e2d72757374792d6d7973746572792d6e6f76656c2d626f6f6b2d636f7665722d68473151684137426942552e6a7067),
(107, 7, 'uefuwe fuwefhb weufhw ifuwhf buwf brwuf bwrfu w', '2024-04-23 11:28:53', 'queen gone crazy', 'the wicked queen', 'fantasy', 0x75706c6f6164732f5468652d5769636b65642d4b696e672d486f6c6c792d426c61636b2e6a7067),
(108, 7, 'q', '2024-04-23 11:32:27', 'q', 'q', 'q', NULL),
(109, 7, 't', '2024-04-23 12:15:40', 't', 't', 't', 0x75706c6f6164732f63616e76612d62726f776e2d72757374792d6d7973746572792d6e6f76656c2d626f6f6b2d636f7665722d68473151684137426942552e6a7067),
(110, 14, 'ifdef efjewifj e9wfij09ewj fresh eriuvhn euifvhnedfuvne vunefdvu fdnvudfnvufdivndfnv ', '2024-04-23 13:11:50', 'my first book ', 'Book', 'horror ', 0x75706c6f6164732f5468652d5769636b65642d4b696e672d486f6c6c792d426c61636b2e6a7067),
(111, 14, 'r', '2024-04-23 13:18:46', 'r', 'r', 'r', 0x75706c6f6164732f63616e76612d62726f776e2d72757374792d6d7973746572792d6e6f76656c2d626f6f6b2d636f7665722d68473151684137426942552e6a7067),
(113, 4, 'buibvdiusdiugv uivb fduivh fivu fdvdfbfbdfb', '2024-04-23 17:50:08', 'ubhjbjbujb', 'tootototo', 'bhbuybuhb ', 0x75706c6f6164732f5468652d5769636b65642d4b696e672d486f6c6c792d426c61636b2e6a7067),
(115, 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sodales ut eu sem integer vitae justo eget magna. In nisl nisi scelerisque eu ultrices vitae auctor eu augue. Pellentesque habitant morbi tristique senectus et netus et. Est pellentesque elit ullamcorper dignissim cras. Porta nibh venenatis cras sed felis eget. Dictum fusce ut placerat orci. Congue mauris rhoncus aenean vel elit scelerisque. Ut tortor pretium viverra suspendisse. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula. Velit aliquet sagittis id consectetur purus ut faucibus pulvinar elementum. Tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Turpis massa sed elementum tempus egestas sed. Mauris nunc congue nisi vitae suscipit tellus.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sodales ut eu sem integer vitae justo eget magna. In nisl nisi scelerisque eu ultrices vitae auctor eu augue. Pellentesque habitant morbi tristique senectus et netus et. Est pellentesque elit ullamcorper dignissim cras. Porta nibh venenatis cras sed felis eget. Dictum fusce ut placerat orci. Congue mauris rhoncus aenean vel elit scelerisque. Ut tortor pretium viverra suspendisse. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula. Velit aliquet sagittis id consectetur purus ut faucibus pulvinar elementum. Tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Turpis massa sed elementum tempus egestas sed. Mauris nunc congue nisi vitae suscipit tellus.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sodales ut eu sem integer vitae justo eget magna. In nisl nisi scelerisque eu ultrices vitae auctor eu augue. Pellentesque habitant morbi tristique senectus et netus et. Est pellentesque elit ullamcorper dignissim cras. Porta nibh venenatis cras sed felis eget. Dictum fusce ut placerat orci. Congue mauris rhoncus aenean vel elit scelerisque. Ut tortor pretium viverra suspendisse. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula. Velit aliquet sagittis id consectetur purus ut faucibus pulvinar elementum. Tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Turpis massa sed elementum tempus egestas sed. Mauris nunc congue nisi vitae suscipit tellus.\r\n\r\n\r\n\r\n', '2024-04-23 19:54:45', 'this book is about an adventure for the soul', 'The adventures of soul ', 'romance ', 0x75706c6f6164732f63616e76612d62726f776e2d72757374792d6d7973746572792d6e6f76656c2d626f6f6b2d636f7665722d68473151684137426942552e6a7067),
(117, 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sodales ut eu sem integer vitae justo eget magna. In nisl nisi scelerisque eu ultrices vitae auctor eu augue. Pellentesque habitant morbi tristique senectus et netus et. Est pellentesque elit ullamcorper dignissim cras. Porta nibh venenatis cras sed felis eget. Dictum fusce ut placerat orci. Congue mauris rhoncus aenean vel elit scelerisque. Ut tortor pretium viverra suspendisse. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula. Velit aliquet sagittis id consectetur purus ut faucibus pulvinar elementum. Tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Turpis massa sed elementum tempus egestas sed. Mauris nunc congue nisi vitae suscipit tellus.\r\n', '2024-04-23 19:59:51', 'this book is very cool!!!', 'This book is cool', 'cool', 0x75706c6f6164732f7465616c2d616e642d6f72616e67652d66616e746173792d626f6f6b2d636f7665722d64657369676e2d74656d706c6174652d30353631303666656239353262646662376266643136623466393332356331312e6a7067),
(127, 27, 'nunuin', '2024-04-25 09:21:19', 'huh', 'dh', 'huihu', 0x75706c6f6164732f7465616c2d616e642d6f72616e67652d66616e746173792d626f6f6b2d636f7665722d64657369676e2d74656d706c6174652d30353631303666656239353262646662376266643136623466393332356331312e6a7067),
(133, 42, 'testing123', '2024-04-25 17:46:53', 'testing', 'test', '123', 0x75706c6f6164732f6f7074696d697a65645f6c617267655f7468756d625f73746167652e6a706567);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `bio` varchar(200) DEFAULT NULL,
  `Profile_picture` blob DEFAULT NULL,
  `theme` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Age`, `Password`, `bio`, `Profile_picture`, `theme`) VALUES
(4, 'Dave', 'Dave@gmail.com', 23, '2', 'I love to write all sorts of books ', 0x75706c6f6164732f706f72736368652d67743372732d6e66732d356b2d31632d3238383078313830302e6a7067, 'light'),
(7, 'jack the best', 'jack@gmail.com', 23, 'blue', 'not', 0x75706c6f6164732f7770373333373438302d616e696d652d6d61632d6169722d77616c6c7061706572732e6a7067, 'light'),
(14, 'Alice', 'Alice@gmail.com', 28, 'red', 'Books', 0x75706c6f6164732f7770383430393532332d616e696d652d6d61632d77616c6c7061706572732e6a7067, 'light'),
(16, 'Grace', 'Grace@gmail.com', 27, 'qwer', 'Books', 0x75706c6f6164732f7770373333373438302d616e696d652d6d61632d6169722d77616c6c7061706572732e6a7067, 'dark'),
(27, 'Abby', 'Abby@gmail.com', 32, 'green', 'hi im abby', 0x75706c6f6164732f3132303070782d323031395f546f796f74615f436f726f6c6c615f49636f6e5f546563685f5656542d695f4879627269645f312e382e6a7067, 'dark'),
(42, 'Mike', 'Mike@gmail.com', 32, 'test', 'I love to read books', 0x75706c6f6164732f3431396772713168343473313635646c716d666e633761696c662e5f53593435305f4352302c302c3435302c3435305f2e6a706567, 'dark');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
