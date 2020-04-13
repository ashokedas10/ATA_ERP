-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2020 at 08:11 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `new_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `define_operations_details_activity`
--

CREATE TABLE IF NOT EXISTS `define_operations_details_activity` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `resource` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `process_quantity` varchar(100) NOT NULL,
  `process_quantity_uom` varchar(100) NOT NULL,
  `per` varchar(100) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `usage_uom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `define_operations_details_activity`
--


-- --------------------------------------------------------

--
-- Table structure for table ` define_operations_summery`
--

CREATE TABLE IF NOT EXISTS ` define_operations_summery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `operation` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `version` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `class_description` varchar(100) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `owner_organization` varchar(100) NOT NULL,
  `owner_description` varchar(100) NOT NULL,
  `minimum_transfer_qty` varchar(100) NOT NULL,
  `process_qty_uom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table ` define_operations_summery`
--


-- --------------------------------------------------------

--
-- Table structure for table ` define_operation_details`
--

CREATE TABLE IF NOT EXISTS ` define_operation_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activity` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `activity_factor` varchar(100) NOT NULL,
  `sequence_defended` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table ` define_operation_details`
--


-- --------------------------------------------------------

--
-- Table structure for table ` define_resources_summery`
--

CREATE TABLE IF NOT EXISTS ` define_resources_summery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `resource` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `usage_uom` int(10) NOT NULL,
  `resource_class` varchar(100) NOT NULL,
  `cost_component_class` int(10) NOT NULL,
  `minimum` int(10) NOT NULL,
  `maximum` int(10) NOT NULL,
  `capacity_uom` int(100) NOT NULL,
  `calculate_charges` int(10) NOT NULL,
  `capacity_tolerace` double(10,2) NOT NULL,
  `utilization` double(10,2) NOT NULL,
  `efficiency` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table ` define_resources_summery`
--


-- --------------------------------------------------------

--
-- Table structure for table `define_routing_summery`
--

CREATE TABLE IF NOT EXISTS `define_routing_summery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `routing` varchar(100) NOT NULL,
  `routing_version` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `routing_description` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `class_description` varchar(100) NOT NULL,
  `valid_from` varchar(100) NOT NULL,
  `valid_to` varchar(100) NOT NULL,
  `quentity` varchar(100) NOT NULL,
  `uom` varchar(100) NOT NULL,
  `planned_loss` double(10,2) NOT NULL,
  `enforce_step_defendency` int(10) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `theoritical_loss` double(10,2) NOT NULL,
  `contiguous` varchar(100) NOT NULL,
  `owner_organization` varchar(100) NOT NULL,
  `fixed_loss` varchar(100) NOT NULL,
  `fixed_loss_uom` varchar(100) NOT NULL,
  `change_status_to` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `define_routing_summery`
--


-- --------------------------------------------------------

--
-- Table structure for table ` inventory_item_attributes_summery`
--

CREATE TABLE IF NOT EXISTS ` inventory_item_attributes_summery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `organization` varchar(100) NOT NULL,
  `item` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `primary` varchar(100) NOT NULL,
  `tracking` int(10) NOT NULL,
  `pricing` int(10) NOT NULL,
  `secondary` varchar(100) NOT NULL,
  `defaulting` int(10) NOT NULL,
  `deviation_factor_+` double(10,2) NOT NULL,
  `deviation_factor_-` double(10,2) NOT NULL,
  `conversions` int(10) NOT NULL,
  `user_item_type` varchar(100) NOT NULL,
  `item_status` varchar(100) NOT NULL,
  `long_description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table ` inventory_item_attributes_summery`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventory_organization_parameters_summery`
--

CREATE TABLE IF NOT EXISTS `inventory_organization_parameters_summery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `organization_code` int(10) NOT NULL,
  `item_master_organization` varchar(100) NOT NULL,
  `calender` varchar(100) NOT NULL,
  `demand_class` varchar(100) NOT NULL,
  `move_order_timeout_period` int(10) NOT NULL,
  `move_order_timeout_action` int(10) NOT NULL,
  `locator_control` int(10) NOT NULL,
  `default_on_hand_material_status` varchar(100) NOT NULL,
  `enforce_locator_alias_uniqueness` int(10) NOT NULL,
  `quality_skipping_inspection_control` int(10) NOT NULL,
  `allow_negative_balences` int(10) NOT NULL,
  `auto_delete_allocations_at_move_order_cancel` int(10) NOT NULL,
  `manufacturing_partner_organization` int(10) NOT NULL,
  `eam_enabled` int(10) NOT NULL,
  `process_manufacturing_enabled` int(10) NOT NULL,
  `wms_enabled` int(10) NOT NULL,
  `wcs_enabled` int(10) NOT NULL,
  `lcm_enabled` int(10) NOT NULL,
  `eam_organization` varchar(100) NOT NULL,
  `load_weight` varchar(100) NOT NULL,
  `load_weight_uom` varchar(100) NOT NULL,
  `volume` varchar(100) NOT NULL,
  `volume_uom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `inventory_organization_parameters_summery`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
