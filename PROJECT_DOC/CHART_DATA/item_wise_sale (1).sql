-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2020 at 11:59 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pharma_staford`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_wise_sale`
--

CREATE TABLE IF NOT EXISTS `item_wise_sale` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `percentige_change` varchar(100) NOT NULL,
  `prev_val` varchar(100) NOT NULL,
  `prev_qty` varchar(100) NOT NULL,
  `curr_value` varchar(100) NOT NULL,
  `curr_qty` varchar(100) NOT NULL,
  `uom` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `item_number` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10242 ;

--
-- Dumping data for table `item_wise_sale`
--

INSERT INTO `item_wise_sale` (`id`, `percentige_change`, `prev_val`, `prev_qty`, `curr_value`, `curr_qty`, `uom`, `product_name`, `item_number`) VALUES
(1, '-24.36', '95127486.14', '122315', '71950411.18', '93640', 'PCS', 'Jutex Plain Board 8x4 Feet T-12 mm D-550', 'FG10000012'),
(2, '-2.79', '69299702.72', '33518', '67368461.41', '29834', 'PCS', 'Ply B.S.Garjon, T-18mm, S-8''X4''', 'FG10035025'),
(3, '12.13', '38052608.95', '54957', '42668858.18', '66500', 'PCS', 'Jutex Plain Board Polar 8x4 Feet T-12 mm', 'FG10000812'),
(4, '-24.22', '47664377.64', '15861', '36118396.28', '10876', 'PCS', 'Ply Decorative O.S Burma Teak & O.S G , T-18mm, S-8''X4''', 'FG10035185'),
(5, '-28.77', '41578625.79', '15694', '29617616.88', '11015', 'PCS', 'V\0B\0 \0O\0/\0S\0 \0B\0u\0r\0m\0a\0 \0T\0e\0a\0k\0,\0T\0-\05\05\00\0/\01\08\0,\0S\0-\08\0''\0??4\0''\0', 'FG10030015'),
(6, '-16.63', '32525229.32', '13338', '27117321.90', '11485', 'PCS', 'V\0B\0 \0O\0/\0S\0 \0B\0u\0r\0m\0a\0 \0T\0e\0a\0k\0,\0T\0-\05\05\00\0/\01\02\0,\0S\0-\08\0''\0??4\0''\0', 'FG10030014'),
(7, '-68.68', '72513375.00', '2197375', '22713900.00', '688300', 'Kg', 'UF Resin for Plain Board', 'FG10090001'),
(8, '-8.18', '23866092.55', '15695', '21912879.84', '14082', 'PCS', 'Ply B.S.Garjon, T-12mm, S-8''X4''', 'FG10035017'),
(9, '-24.9', '18146981.87', '7258', '13627717.11', '4729', 'PCS', 'Ply Decorative O.S Burma Teak & O.S G , T-12mm, S-8''X4''', 'FG10035125'),
(10, '-21.94', '16343222.21', '13547', '12757604.24', '9557', 'PCS', 'Ply B.S.Garjon, T-6mm, S-8''X4''', 'FG10035009'),
(11, '-37.6', '18244893.67', '17610', '11385268.98', '13546', 'PCS', 'Jutex Plain Board 8x4 Feet T-18 mm D-550', 'FG10000018'),
(12, '-21.48', '11638307.16', '6272', '9138872.63', '4929', 'PCS', 'V\0B\0 \0O\0/\0S\0 \0G\0a\0r\0j\0o\0n\0,\0T\0-\05\05\00\0/\01\08\0,\0S\0-\08\0''\0??4\0''\0', 'FG10030071'),
(13, '3661.86', '181014.36', '15', '6809513.72', '116', 'PCS', 'SWD:BURMA TEAK,THICKNESS 36MM', 'OS10045811'),
(14, '-27.56', '8896737.75', '4608', '6444810.58', '3315', 'PCS', 'VB O/S Crown Teak,T-550/12,S-8''x4''', 'FG10030118'),
(15, '-43.4', '10909681.21', '7565', '6174866.88', '4177', 'PCS', 'V\0B\0 \0B\0/\0S\0 \0B\0.\0C\0o\0m\0m\0e\0r\0c\0i\0a\0l\0,\0T\0-\05\05\00\0/\01\02\0,\0S\0-\08\0''\0??4\0''\0', 'FG10030098'),
(16, '-64.02', '15834004.35', '7273', '5697206.08', '3148', 'PCS', 'LP.: B. Teak, (CLP) T-400/36, S-Various', 'FG10040901'),
(17, '-25.45', '7600417.98', '3537', '5666416.73', '2784', 'PCS', 'VB O/S Crown Teak,T-550/18,S-8''x4''', 'FG10030119'),
(18, '-18.24', '6461835.16', '3573', '5283347.72', '2951', 'PCS', 'V\0B\0 \0B\0/\0S\0 \0B\0.\0C\0o\0m\0m\0e\0r\0c\0i\0a\0l\0,\0T\0-\05\05\00\0/\01\08\0,\0S\0-\08\0''\0??4\0''\0', 'FG10030099'),
(19, '-9.49', '5785905.10', '4284', '5236926.45', '4196', 'PCS', 'LP.: Gorjon (MLP), T-400/36, S-Various', 'FG10041711'),
(20, '-39.74', '7953731.03', '3386', '4793234.44', '2571', 'PCS', 'LP.: B. Teak, (MLP) T-400/36, S-Various', 'FG10041724'),
(21, '0.00', '0.00', '3', '0', '13', 'PCS', 'Jutex Plain Board 8x4 Feet T-36 mm D-400', 'FG10000036'),
(22, '0.00', '0.00', '0', '0', '2', 'PCS', 'LP.:Garjon (JLP),T-400/36,S-6-10''X2-9''', 'FG10040004'),
(23, '0.00', '189114.88', '72', '0', '1', 'PCS', 'VB O/S Champ Regular,T-550/18,S-8''x4''', 'FG10030551'),
(24, '-99.97', '4340.16', '1', '0', '1', 'PCS', 'VB O/S Champ regular,T-425/26,S-8''x4''', 'FG10030829'),
(25, '0.00', '42265.58', '27', '0', '1', 'PCS', 'LP.: PD-027+Champ, (MLP) T-400/36, S-Various', 'FG10042260'),
(26, '0.00', '0.00', '0', '0', '1', 'PCS', 'LP.:S.Teak (MLP),T-400/36,S-6-10''X2-9''', 'FG10042735'),
(27, '0.00', '0.00', '0', '41', '1', 'PCS', 'LP.: PD-038+Champ, Polish (CLP) T-400/36, S-Various', 'FG10041499'),
(28, '0.00', '0.00', '0', '50', '1', 'PCS', 'LP.: CD-011 (OSD+Champ)Polish, (CLP) T-400/36, S-Various', 'FG10041304'),
(29, '-99.97', '2969202.15', '4557', '800', '1', 'PCS', 'MDF Plain Board 8x4 Feet T-12mm Density:730-750mm', 'FG10000834'),
(30, '-99.71', '273776.24', '338', '800', '1', 'PCS', 'Veneered Grade MDF PLAIN BOARD, 4''x8''x18mm', 'RM10089034'),
(31, '-99.97', '4792097.62', '7173', '1600', '2', 'PCS', 'MDF Plain Board 8x4 Feet T-15mm Density:730-750mm', 'FG10000835'),
(32, '-87.50', '16875.52', '8', '2109', '1', 'PCS', 'Ply Decorative O.S GoldenTeak & O.S G , T-3mm, S-8''X4''', 'FG10035037'),
(33, '-75.00', '10000.00', '20', '2500', '5', 'Kg', 'Veneer edging B. Teak', 'FG10030585'),
(34, '-96.05', '64465.68', '60', '2545', '2', 'PCS', 'LP.: Eco Door (new) (BS), (MLP) T-400/36, S-Various', 'FG10042659'),
(35, '-75.00', '10798.08', '4', '2700', '1', 'PCS', 'Ply Decorative O.S Sheddy Brown & O.S G , T-6mm, S-8''X4''', 'FG10035111'),
(36, '0.00', '0.00', '0', '2757', '9', 'PCS', 'LP.: Champ cabinet Door, (MLP) T-425/25, S-Various', 'FG10044366'),
(37, '0.00', '0.00', '0', '2898', '2', 'PCS', 'LP.:Champ Regular(MLP),T-400/36,S-6-10X2-0''', 'FG10090935'),
(38, '0.00', '0.00', '0', '2955', '2', 'PCS', 'LP.:G.Teak (CLP),T-400/36,G-6-10''X2-0''', 'FG10042717'),
(39, '0.00', '0.00', '0', '2959', '2', 'PCS', 'LP.:Champ(MLP),T-400/36,S-6-10X2-0''', 'FG10040056'),
(40, '-50.00', '6227.00', '4', '3114', '2', 'PCS', 'LP.:Gorjon(MLP),T-400/36,S-6-10X2-6''', 'FG10040047');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
