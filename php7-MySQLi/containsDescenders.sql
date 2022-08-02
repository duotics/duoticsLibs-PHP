-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2021 at 02:33 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `merco_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_term_block`
--

CREATE TABLE `tbl_contact_term_block` (
  `id` int(11) NOT NULL,
  `term` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `cont_block` int(11) DEFAULT 0 COMMENT 'How many times can be blocked this word',
  `stat` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Dominios bloqueados de contact mail';

--
-- Dumping data for table `tbl_contact_term_block`
--

INSERT INTO `tbl_contact_term_block` (`id`, `term`, `date`, `cont_block`, `stat`) VALUES
(1, 'viagra', '2019-07-16', 0, '1'),
(2, 'biagra', '2019-07-16', 0, '1'),
(3, 'sex', '2019-07-16', 0, '1'),
(4, 'sexo', '2019-07-16', 0, '1'),
(5, 'cialis', '2019-07-16', 0, '1'),
(6, 'psychology', '2019-07-16', 0, '1'),
(7, 'psicología', '2019-07-16', 0, '1'),
(8, 'fat', '2019-07-16', 0, '1'),
(9, 'loss weight', '2019-07-16', 0, '1'),
(10, 'perdida de peso', '2019-07-16', 0, '1'),
(11, 'bitcoin', '2019-07-16', 0, '1'),
(12, 'bitcoins', '2019-07-16', 0, '1'),
(15, 'captcha', '2019-07-16', 0, '1'),
(16, 'ReCaptcha', '2019-07-16', 0, '1'),
(17, 'virgin', '2019-07-16', 0, '1'),
(18, 'virginity', '2019-07-16', 0, '1'),
(19, 'cock', '2019-07-16', 0, '1'),
(20, 'fuck', '2019-07-16', 0, '1'),
(21, 'escort', '2019-07-16', 0, '1'),
(22, 'singer', '2019-07-16', 0, '1'),
(23, 'concert', '2019-07-16', 0, '1'),
(24, 'concerts', '2019-07-16', 0, '1'),
(25, 'Benadryl', '2019-07-16', 0, '1'),
(26, 'Allergy', '2019-07-16', 0, '1'),
(27, 'Protein', '2019-07-16', 0, '1'),
(28, 'Jewelry', '2019-07-16', 0, '1'),
(29, 'Music', '2019-07-16', 0, '1'),
(30, 'Houzz', '2019-09-24', 0, '1'),
(31, 'HouZzilla', '2019-09-24', 0, '1'),
(32, 'traffic', '2019-09-24', 0, '1'),
(33, 'адвокат', '2019-09-24', 0, '1'),
(34, 'mailing', '2019-10-22', 0, '1'),
(35, ' FeedbackForm', '2019-10-22', 0, '1'),
(36, 'nsksoft.net', '2019-10-28', 0, '1'),
(37, 'Ufabet', '2019-10-28', 0, '1'),
(38, 'Gaming', '2019-10-28', 0, '1'),
(39, 'valium', '2019-11-01', 0, '1'),
(40, 'pharmacy', '2019-11-01', 0, '1'),
(41, 'herbal', '2019-11-01', 0, '1'),
(42, 'propecia', '2019-11-11', 0, '1'),
(43, 'hair-loss', '2019-11-11', 0, '1'),
(44, 'hair loss', '2019-11-11', 0, '1'),
(45, 'Uberwin', '2019-11-11', 0, '1'),
(46, 'Uberwin.club', '2019-11-11', 0, '1'),
(47, 'Spegra', '2019-11-12', 0, '1'),
(48, 'Долутеглавир', '2019-11-12', 0, '1'),
(49, 'Тенофовир', '2019-11-12', 0, '1'),
(50, 'алафенамид', '2019-11-12', 0, '1'),
(51, 'Эмтрицитабин', '2019-11-12', 0, '1'),
(52, 'VIH', '2019-11-12', 0, '1'),
(53, 'HIV', '2019-11-12', 0, '1'),
(54, 'ВИЧ', '2019-11-12', 0, '1'),
(55, 'аптеке', '2019-11-12', 0, '1'),
(57, 'farmacia', '2019-11-12', 0, '1'),
(58, 'лекарству', '2019-11-12', 0, '1'),
(59, 'medicina', '2019-11-12', 0, '1'),
(60, 'medicine', '2019-11-12', 0, '1'),
(61, 'летальный', '2019-11-12', 0, '1'),
(62, 'drugs', '2019-11-12', 0, '1'),
(63, 'revolut.com', '2019-11-12', 0, '1'),
(64, 'banking app', '2019-11-12', 0, '1'),
(65, 'payment card', '2019-11-12', 0, '1'),
(66, 'ecodes', '2019-11-12', 0, '1'),
(67, 'cdhost.com', '2019-11-12', 0, '1'),
(68, 'herbal smoke', '2019-11-12', 0, '1'),
(69, 'лекарств', '2019-11-19', 0, '1'),
(70, 'медикаменты', '2019-11-19', 0, '1'),
(71, 'медицина', '2019-11-19', 0, '1'),
(72, 'tofacitinib', '2019-11-19', 0, '1'),
(73, 'тофацитиниб', '2019-11-19', 0, '1'),
(74, 'stilnox', '2019-11-19', 0, '1'),
(76, 'clanwebsite', '2019-11-19', 0, '1'),
(77, 'vinalac', '2019-11-27', 0, '1'),
(78, 'Haifa', '2019-12-02', 0, '1'),
(79, 'рускоязычный', '2019-12-02', 0, '1'),
(80, 'хайфая', '2019-12-02', 0, '1'),
(81, 'torrents', '2020-01-09', 0, '1'),
(82, 'BitTorrent', '2020-01-09', 0, '1'),
(83, 'uTorrent', '2020-01-09', 0, '1'),
(84, 'qBittorrent', '2020-01-09', 0, '1'),
(85, 'peer-to-peer', '2020-01-09', 0, '1'),
(86, 'casino', '2020-01-09', 0, '1'),
(87, 'jackpot', '2020-01-09', 0, '1'),
(88, 'gambling', '2020-01-09', 0, '1'),
(89, 'bingo', '2020-01-09', 0, '1'),
(90, 'мужчиной', '2020-02-02', 0, '1'),
(91, 'софосбувир', '2020-02-02', 0, '1'),
(92, 'Daclatasvir', '2020-02-02', 0, '1'),
(93, 'отдыхает', '2020-02-02', 0, '1'),
(94, 'отдыху', '2020-02-02', 0, '1'),
(95, 'drug', '2020-02-14', 0, '1'),
(96, 'yandex', '2020-02-28', 0, '1'),
(97, 'Кстово', '2020-02-28', 0, '1'),
(98, 'скважин', '2020-03-03', 0, '1'),
(99, 'скважины', '2020-03-03', 0, '1'),
(100, 'Y2mate', '2020-03-04', 0, '1'),
(101, 'ytmp3', '2020-03-04', 0, '1'),
(102, '2conv', '2020-03-04', 0, '1'),
(103, 'themerchantlendr', '2020-03-12', 0, '1'),
(104, 'piroxicam', '2020-03-25', 0, '1'),
(105, 'xanax', '2020-03-25', 0, '1'),
(106, 'xanaxcan', '2020-03-25', 0, '1'),
(107, 'ativan', '2020-03-25', 0, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_contact_term_block`
--
ALTER TABLE `tbl_contact_term_block`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `term` (`term`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_contact_term_block`
--
ALTER TABLE `tbl_contact_term_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;
