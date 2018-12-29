#
# TABLE STRUCTURE FOR: admin_groups
#

DROP TABLE IF EXISTS `admin_groups`;

CREATE TABLE `admin_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('1', 'webmaster', 'Webmaster');
INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('2', 'admin', 'Administrator');
INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('3', 'manager', 'Manager');
INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('4', 'staff', 'Staff');


#
# TABLE STRUCTURE FOR: admin_login_attempts
#

DROP TABLE IF EXISTS `admin_login_attempts`;

CREATE TABLE `admin_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: admin_users
#

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('1', '127.0.0.1', 'webmaster', '$2y$08$/X5gzWjesYi78GqeAv5tA.dVGBVP7C1e1PzqnYCVe5s1qhlDIPPES', NULL, NULL, NULL, NULL, NULL, 'StLbqBF3j7FRHjJ3t45JCO', '1451900190', '1504160490', '1', 'Webmaster', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('2', '127.0.0.1', 'admin', '$2y$08$7Bkco6JXtC3Hu6g9ngLZDuHsFLvT7cyAxiz1FzxlX5vwccvRT7nKW', NULL, NULL, NULL, NULL, NULL, NULL, '1451900228', '1465489580', '1', 'Admin', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('3', '127.0.0.1', 'manager', '$2y$08$snzIJdFXvg/rSHe0SndIAuvZyjktkjUxBXkrrGdkPy1K6r5r/dMLa', NULL, NULL, NULL, NULL, NULL, NULL, '1451900430', '1465489585', '1', 'Manager', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('4', '127.0.0.1', 'staff', '$2y$08$NigAXjN23CRKllqe3KmjYuWXD5iSRPY812SijlhGeKfkrMKde9da6', NULL, NULL, NULL, NULL, NULL, NULL, '1451900439', '1465489590', '1', 'Staff', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('5', '::1', 'ravi2katre@gmail.com', '$2y$08$2c7fglguF3b0yIcvx4AvPOvYZWWJMB9EkRNL4Wr0En8r1qqOeOXLe', NULL, 'ravi2katre@gmail.com', NULL, NULL, NULL, NULL, '1504178236', NULL, '1', 'rrr', 'fgfg');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('6', '::1', 'ravi22katre@gmail.com', '$2y$08$gF0wSLtjtrdZovScW/Wcs.tN.kBhAkTfw52t2G65nf1Cm19icJ46O', NULL, 'ravi22katre@gmail.com', NULL, NULL, NULL, NULL, '1504178297', NULL, '1', 'ddf', 'dfdff');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('7', '::1', 'ravi2katre@ymail.com', '$2y$08$YgrHa785/eqUMKxnGGHLtuf41bw.E28ZS3bGXxE5zgSyv5ySPsKDa', NULL, 'ravi2katre@ymail.com', NULL, NULL, NULL, NULL, '1504178655', NULL, '1', 'aa', 'ss');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('8', '::1', 'dfdfd@ff.com', '$2y$08$NCPVS1QygDKZh176A48eXOfBVOXz.00y6AT/6aKPFHScCSe2gMG92', NULL, 'dfdfd@ff.com', NULL, NULL, NULL, NULL, '1504179205', NULL, '1', 'dfdff', 'dfdfdf');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('9', '::1', 'sdsd@ff.com', '$2y$08$/qTeBABIFk8U29ll7IbWR.2RcOG/HY8JdpbH6kn.uvsLAn7xkAmXK', NULL, 'sdsd@ff.com', NULL, NULL, NULL, NULL, '1504179293', NULL, '1', 'ssdsd', 'sdsdsd');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('10', '::1', 'dfdf@gg.com', '$2y$08$fIJDdAqkZKwUPrsRSInK9ebEOjWsLo9hMAkFdyhC1K0AFwiMD2GW6', NULL, 'dfdf@gg.com', NULL, NULL, NULL, NULL, '1504179348', NULL, '1', 'dfdf', 'dfdf');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('11', '::1', 'dfff@ff.com', '$2y$08$QT5v/cSd/0CmYTqbul71yuwmko/dD9uGEvwP4cWPJ2CSMkrCMDCTa', NULL, 'dfff@ff.com', NULL, NULL, NULL, NULL, '1504179482', NULL, '1', 'ddd', 'dfdf');


#
# TABLE STRUCTURE FOR: admin_users_groups
#

DROP TABLE IF EXISTS `admin_users_groups`;

CREATE TABLE `admin_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('1', '1', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('2', '2', '2');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('3', '3', '3');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('4', '4', '4');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('5', '5', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('6', '6', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('7', '7', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('8', '8', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('9', '9', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('10', '10', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('11', '11', '1');


#
# TABLE STRUCTURE FOR: api_access
#

DROP TABLE IF EXISTS `api_access`;

CREATE TABLE `api_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL DEFAULT '',
  `controller` varchar(50) NOT NULL DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: api_keys
#

DROP TABLE IF EXISTS `api_keys`;

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `api_keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES ('1', '0', 'anonymous', '1', '1', '0', NULL, '1463388382');


#
# TABLE STRUCTURE FOR: api_limits
#

DROP TABLE IF EXISTS `api_limits`;

CREATE TABLE `api_limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: api_logs
#

DROP TABLE IF EXISTS `api_logs`;

CREATE TABLE `api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: emails
#

DROP TABLE IF EXISTS `emails`;

CREATE TABLE `emails` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(128) NOT NULL,
  `mail_from` varchar(128) NOT NULL,
  `mail_from_name` varchar(255) DEFAULT NULL,
  `mail_to` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: events
#

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `Images` int(11) NOT NULL,
  `comments` tinytext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: groups
#

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('1', 'webmaster', 'General User');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('2', 'Admin', '');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('3', 'Executive', '');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('4', 'Supplier', '');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('5', 'Farmer', '');


#
# TABLE STRUCTURE FOR: inquiries
#

DROP TABLE IF EXISTS `inquiries`;

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `details` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('1', '21', '2', 'ineed', 'ravi2katre@gmail.com', 'ineed', '2018-09-07 17:36:18');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('2', '21', '2', 'shagu', 'shagu@gmail.com', 'ineed', '2018-09-07 17:37:13');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('3', '21', '2', 'Saller', 'ravi2katre@gmail.com', 'ineed', '2018-09-08 03:58:52');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('4', '21', '2', 'Saller', 'ravi2katre@gmail.com', 'ineed', '2018-09-08 04:06:30');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('5', '35', '0', '', 'ravi2katre@gmail.com', 'sddsdsdsd  dsdsds ', '2018-09-08 05:27:22');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('6', '35', '0', 'Ravi', 'ravi2katre@gmail.com', 'ss sss', '2018-09-08 05:51:55');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('7', '38', '0', 'ineed', '5656', 'weww', '2018-09-08 05:55:02');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('8', '36', '40', 'dfdfs', 'ravi2katre@gmail.com', 'ssdsa', '2018-09-08 05:57:09');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('9', '36', '40', 'shagu', 'ravi2katre@gmail.com', '', '2018-09-08 06:10:00');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('10', '38', '40', 'dsd', 'ravi2katre@gmail.com', 'sdsd', '2018-09-08 06:22:05');
INSERT INTO `inquiries` (`id`, `product_id`, `user_id`, `name`, `email`, `details`, `date`) VALUES ('11', '38', '40', 'dsd', 'ravi2katre@gmail.com', 'sdsd', '2018-09-08 06:22:10');


#
# TABLE STRUCTURE FOR: login_attempts
#

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: menus
#

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `liniage` varchar(255) NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL,
  `children` varchar(255) NOT NULL,
  `sort_by` smallint(6) NOT NULL DEFAULT '0',
  `content` text,
  `image_url` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('8', '0', 'Home', 'home', '/8', 'fa fa-home', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('9', '11', 'Users', 'users', '/11/9', 'fa fa-users', '', '2', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('10', '11', 'Account', 'panel/account', '/11/10', 'fa fa-cog', '', '200', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('11', '0', 'Utilities', 'util/list_db', '/11', 'fa fa-cogs', '', '90', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('12', '0', 'Sign Out', 'panel/logout', '/12', 'fa fa-sign-out', '', '100', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('13', '11', 'Database version', 'util/list_db', '/11/13', 'fa fa-circle-o text-aqua', '', '300', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('15', '11', 'Menu', 'menus', '/11/15', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('16', '11', 'Emails', 'emails', '/11/16', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('20', '0', 'Executives', 'executives', '/20', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('21', '0', 'Farmers', 'farmers', '/21', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('22', '0', 'Events', 'events', '/22', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('24', '11', 'Groups', 'groups', '/11/24', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('25', '0', 'Suppliers', 'suppliers', '/25', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('26', '0', 'Web Content Pages', 'menus', '/26', 'fa fa-circle', '', '100', '<p><span style=\"font-family: &quot;Comic Sans MS&quot;;\">ssdsdssds<span style=\"background-color: rgb(0, 0, 0);\">dsvdsfds </span></span><span style=\"background-color: rgb(0, 0, 0);\">fffs dff</span><br></p>', NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('27', '26', 'Main Menus', 'menus/front_pages', '/26/27', '', '', '120', 'dff', NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('28', '26', 'Products', 'menus/product_pages', '/26/28', 'fa fa-circle', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('29', '28', 'Prouct 1', 'Prouct 1', '/26/28/29', 'fa fa-circle', '', '0', 'Lorem ipsum dolor consectetur scinglit. Phasellus eu fff dplacerat justo. Nam vesih itibulum erdiet suscipit ac tstique ibero.', 'prod14.jpg', '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('30', '27', 'Home', 'home', '/26/27/30', '', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('31', '27', 'About Us', 'about_us', '/26/27/31', '', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('32', '27', 'What We Do', 'what_we_do', '/26/27/32', '', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('33', '27', 'Our Products', 'our_products', '/26/27/33', '', '', '0', NULL, NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('34', '27', 'Contact', 'contact', '/26/27/34', '', '', '0', 'hello', NULL, '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('35', '28', 'Prouct 2', 'Prouct 2', '/26/28/35', '', '', '0', 'Lorem ipsum dolor consectetur scinglit. Phasellus eu fff dplacerat justo. Nam vesih itibulum erdiet suscipit ac tstique ibero.', 'prod13.jpg', '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('36', '28', 'Prouct 3', 'Prouct 3', '/26/28/36', '', '', '0', 'Lorem ipsum dolor consectetur scinglit. Phasellus eu fff dplacerat justo. Nam vesih itibulum erdiet suscipit ac tstique ibero.', 'prod12.jpg', '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('37', '28', 'Prouct 4', 'Prouct 4', '/26/28/37', '', '', '0', 'Lorem ipsum dolor consectetur scinglit. Phasellus eu fff dplacerat justo. Nam vesih itibulum erdiet suscipit ac tstique ibero.', 'prod11.jpg', '0', '2018-09-07 15:54:27');
INSERT INTO `menus` (`menu_id`, `parent_id`, `name`, `url`, `liniage`, `icon`, `children`, `sort_by`, `content`, `image_url`, `user_id`, `date`) VALUES ('38', '28', 'Prouct 5', 'Prouct 5', '/26/28/38', '', '', '0', '<p>Lorem ipsum dolor consectetur scinglit. Phasellus eu fff dplacerat justo. Nam vesih itibulum erdiet suscipit ac tstique ibero.</p>', 'prod1.jpg', '1', '2018-09-07 15:54:27');


#
# TABLE STRUCTURE FOR: menus_20180829
#

DROP TABLE IF EXISTS `menus_20180829`;

CREATE TABLE `menus_20180829` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `children` varchar(255) NOT NULL,
  `sort_by` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('8', '0', 'Home', 'home', 'fa fa-home', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('9', '11', 'Users', 'users', 'fa fa-users', '', '2');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('10', '11', 'Account', 'panel/account', 'fa fa-cog', '', '200');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('11', '0', 'Utilities', 'util/list_db', 'fa fa-cogs', '', '90');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('12', '0', 'Sign Out', 'panel/logout', 'fa fa-sign-out', '', '100');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('13', '11', 'Database version', 'util/list_db', 'fa fa-circle-o text-aqua', '', '300');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('15', '11', 'Menu', 'menus', 'fa fa-circle', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('16', '11', 'Emails', 'emails', 'fa fa-circle', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('20', '0', 'Executives', 'executives', 'fa fa-circle', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('21', '0', 'Farmers', 'farmers', 'fa fa-circle', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('22', '0', 'Events', 'events', 'fa fa-circle', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('24', '11', 'Groups', 'groups', 'fa fa-circle', '', '0');
INSERT INTO `menus_20180829` (`menu_id`, `parent_id`, `name`, `url`, `icon`, `children`, `sort_by`) VALUES ('25', '0', 'Suppliers', 'suppliers', 'fa fa-circle', '', '0');


#
# TABLE STRUCTURE FOR: menus_groups
#

DROP TABLE IF EXISTS `menus_groups`;

CREATE TABLE `menus_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `menu_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=275 DEFAULT CHARSET=latin1;

INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('6', '1', '16');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('120', '1', '8');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('119', '2', '25');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('62', '1', '21');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('117', '1', '22');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('16', '1', '23');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('17', '1', '9');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('19', '1', '24');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('65', '2', '20');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('64', '1', '20');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('63', '2', '21');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('118', '1', '25');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('254', '5', '38');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('253', '4', '38');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('252', '3', '38');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('251', '2', '38');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('250', '1', '38');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('259', '5', '37');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('258', '4', '37');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('257', '3', '37');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('256', '2', '37');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('255', '1', '37');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('121', '2', '8');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('116', '1', '11');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('86', '2', '26');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('85', '1', '26');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('79', '2', '27');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('78', '1', '27');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('74', '1', '0');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('75', '2', '0');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('90', '2', '28');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('89', '1', '28');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('274', '5', '29');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('273', '4', '29');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('272', '3', '29');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('271', '2', '29');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('270', '1', '29');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('91', '1', '30');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('92', '2', '30');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('93', '3', '30');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('94', '4', '30');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('95', '5', '30');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('96', '1', '31');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('97', '2', '31');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('98', '3', '31');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('99', '4', '31');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('100', '5', '31');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('101', '1', '32');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('102', '2', '32');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('103', '3', '32');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('104', '4', '32');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('105', '5', '32');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('106', '1', '33');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('107', '2', '33');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('108', '3', '33');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('109', '4', '33');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('110', '5', '33');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('164', '5', '34');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('163', '4', '34');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('162', '3', '34');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('161', '2', '34');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('160', '1', '34');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('122', '3', '8');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('123', '4', '8');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('124', '5', '8');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('269', '5', '35');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('268', '4', '35');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('267', '3', '35');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('266', '2', '35');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('265', '1', '35');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('264', '5', '36');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('263', '4', '36');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('262', '3', '36');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('261', '2', '36');
INSERT INTO `menus_groups` (`id`, `group_id`, `menu_id`) VALUES ('260', '1', '36');


#
# TABLE STRUCTURE FOR: students_parents
#

DROP TABLE IF EXISTS `students_parents`;

CREATE TABLE `students_parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `students_parents` (`id`, `student_id`, `parent_id`) VALUES ('1', '9', '32');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('1', '127.0.0.1', 'webmaster@webmaster.com', '$2y$08$8dQguKPzqm8JAzvYqHiWP.q3qvIqelUxEjMX2JiulIG749fBiPStO', NULL, 'webmaster@member.com', NULL, NULL, NULL, NULL, '1451903855', '1536472310', '1', 'webmaster', NULL, 'webmaster', NULL, NULL, NULL, '0', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('7', '::1', 'supplier@supplier.com', '$2y$08$QTsLE0v1s3TQx/9OamCx/eDJxEWpJ.HnDFx5/DZaKpt/XSJeewrUS', NULL, 'supplier@supplier.com', NULL, NULL, NULL, NULL, '1504261130', NULL, '1', 'Supplier', NULL, 'Gondia', NULL, NULL, NULL, '0', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('8', '::1', 'executive@executive.com', '$2y$08$I39WFVQWespx4zpMQaxZvOgv4Y96CB6rEuhiwBiISMXQZMNrjSD4a', NULL, 'executive@executive.com', NULL, NULL, NULL, NULL, '1504615142', NULL, '1', 'executive', NULL, 'Nagpur', NULL, '9881815256', NULL, 'ny 10', NULL, '3333', NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('10', '::1', 'rkatre1@tiuconsulting.com', '$2y$08$2vBEx6KWZPpo4t6CmmFRFOEBZqGw0pZdMzNvb7ntv3vuh48DD3Lq2', NULL, 'rkatre1@tiuconsulting.com', NULL, NULL, NULL, NULL, '1507606423', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('11', '::1', 'rkatre2@tiuconsulting.com', '$2y$08$QjF/f77yluMGtPxfTCYMpuR.tRStamHFWZFhId0V1kvssr.cMA/n2', NULL, 'rkatre2@tiuconsulting.com', NULL, NULL, NULL, NULL, '1507608813', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('12', '::1', 'rkatre3@tiuconsulting.com', '$2y$08$9EWZvL1yUOqNZhMt3sBcq..AWh3SXW3n/62E83eaIj66bbozCTzNC', NULL, 'rkatre3@tiuconsulting.com', NULL, NULL, NULL, NULL, '1507608845', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('13', '::1', 'ravi2katre@gmail.com', '$2y$08$ArLGAGtZVOgQVWTdHZhzt.BiA94PkwrA3/ITn67CFUjUM9UUwIU4.', NULL, 'ravi2katre@gmail.com', NULL, NULL, NULL, NULL, '1507609653', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('14', '::1', 'ravi2katre5@gmail.com', '$2y$08$rKe1ELE7d0mPbcXun6xTdeIjWlzAEV/MFjVS36KpNljHIAYaOo13W', NULL, 'ravi2katre5@gmail.com', NULL, NULL, NULL, NULL, '1507609741', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('15', '::1', 'ravi2katre1@gmail.com', '$2y$08$1WAJmm2kbzg4Szhuybpy2.gq4bTW.4zIyDafr4OyKQbDLtUTTxXKq', NULL, 'ravi2katre1@gmail.com', NULL, NULL, NULL, NULL, '1507609992', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('16', '::1', 'ravi2katre2@gmail.com', '$2y$08$EWzBuFPJVtyjQk2BGBqTnOuhGIXTlZq/tVnYN/Kws5wcOy2TXcyJS', NULL, 'ravi2katre2@gmail.com', NULL, NULL, NULL, NULL, '1507610108', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('17', '::1', 'ravi2katre6@gmail.com', '$2y$08$ewPt.AeXbAUtQC6TVmrgcOAa/0rup9FoIM1TDFo1TmRStey/pT8He', NULL, 'ravi2katre6@gmail.com', NULL, NULL, NULL, NULL, '1507610624', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('18', '::1', 'ravi2katre7@gmail.com', '$2y$08$E1BYqVqiW8j2K01qVfa6XusB7COItmfRvbzeUwREkN.ktmWvGxiJm', NULL, 'ravi2katre7@gmail.com', NULL, NULL, NULL, NULL, '1507610780', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('19', '::1', 'ravi2katre8@gmail.com', '$2y$08$mSmGwayX6SFe3TdA68X5m.TN6JwZFCQKiGxgGf7W5Yl9qT/rOH.nO', NULL, 'ravi2katre8@gmail.com', NULL, NULL, NULL, NULL, '1507610899', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('20', '::1', 'ravi2katre9@gmail.com', '$2y$08$CGNZDBpozIeWUee7Fe55nuBpUXWCXzQogrbgr1JNW2ovDLQG1hGhe', NULL, 'ravi2katre9@gmail.com', NULL, NULL, NULL, NULL, '1507610948', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('21', '::1', 'ravi2katre10@gmail.com', '$2y$08$AdRmPOEi0b49oSHePn3HQ.4znV23OKH12KhQWso6F.2Tp5.TN0xVm', NULL, 'ravi2katre10@gmail.com', NULL, NULL, NULL, NULL, '1507611095', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('33', '::1', 'executives@executives.com', '$2y$08$kkVNTa8mVFVea6psj3A.NeVRcutUOR5Y8F5W7V.iQgEsuVTo7Eqdi', NULL, 'executives@executives.com', NULL, NULL, NULL, NULL, '1534325274', '1536057332', '1', 'Executives', 'sdsds', 'Gondia', NULL, '9881815256', '988185256', 'address', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('35', '49.14.34.222', 'admin', '$2y$08$ntcujFk8TLP50Y0WhZQRueoLMppJnf37azeqnWE4JPUpfdlIOpaRm', NULL, 'admin', NULL, NULL, NULL, NULL, '1536252339', '1536297820', '1', 'admin', NULL, 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('38', '59.97.236.245', '567891', '$2y$08$lqVp7zQfN3BH1eA0SdGV4.B5ypmf2rdtFclxW5/n6ULfr54IiBcYC', NULL, '', NULL, NULL, NULL, NULL, '1536319830', '1536319856', '1', NULL, NULL, NULL, NULL, '567891', NULL, NULL, 'gondia', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('39', '59.97.236.245', '444444', '$2y$08$fCege4khN5bQgrwYbqfffeoJ3Zc9vtzR4SFIQLxxpO12nsBy2bDdS', NULL, '', NULL, NULL, NULL, NULL, '1536320369', '1536320423', '1', NULL, NULL, NULL, NULL, '444444', NULL, NULL, 'gondia', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('40', '103.106.101.17', '9881815256', '$2y$08$lZ0k0X70JBAJKHUJozi67uguEY.0E6DPXYlUoZ6Ok4bGS/WfFHFFS', NULL, '', NULL, NULL, NULL, NULL, '1536382624', NULL, '1', NULL, NULL, NULL, NULL, '9881815256', NULL, NULL, 'nagpur', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('41', '103.106.101.17', '8600710403', '$2y$08$l2RI4QsBrUTBSvpSzIjW3e/VU/rKh4GO4wbqYbt5aQU22LMh30bk2', NULL, '', NULL, NULL, NULL, NULL, '1536383521', NULL, '1', NULL, NULL, NULL, NULL, '8600710403', NULL, NULL, 'Nagpur', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('42', '103.106.101.17', '9854214587', '$2y$08$1Ecqng1xyDnch4lN08V50.UU0Zo0yvgML1W267jZVpyoXCXlabvve', NULL, '', NULL, NULL, NULL, NULL, '1536384633', NULL, '1', NULL, NULL, NULL, NULL, '9854214587', NULL, NULL, 'Nagpur', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('43', '106.78.194.94', '343434', '$2y$08$0feMfpqYvqZxqEtkDd7s2.EWKjJztf4qvLccrsB9wzLXS7T8e/2Tm', NULL, '', NULL, NULL, NULL, NULL, '1536399278', NULL, '1', NULL, NULL, NULL, NULL, '343434', NULL, NULL, 'fdfd', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('44', '106.78.194.94', '908776675676', '$2y$08$Jj72MaxXAlGOh8KYpU7LS.lWo4xxVs/k6uQnbHjmZGiPD4yq6Y3Fe', NULL, '', NULL, NULL, NULL, NULL, '1536404702', NULL, '1', NULL, NULL, NULL, NULL, '908776675676', NULL, NULL, 'gondia', NULL, NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `middle_name`, `last_name`, `company`, `phone`, `phone2`, `address`, `city`, `fax`, `image_url`) VALUES ('45', '49.35.19.174', '9845751458', '$2y$08$jYluymuCS8h23Q2sEaCLye.9D.CAEBy6cVHqEVW6SMO2YVnmKckhW', NULL, '', NULL, NULL, NULL, NULL, '1536414051', NULL, '1', NULL, NULL, NULL, NULL, '9845751458', NULL, NULL, 'Nagpur', NULL, NULL);


#
# TABLE STRUCTURE FOR: users_groups
#

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('3', '4', '1');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('4', '5', '1');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('7', '3', '1');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('11', '9', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('12', '10', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('13', '11', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('14', '12', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('15', '13', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('16', '14', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('17', '15', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('18', '16', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('19', '17', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('20', '18', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('21', '19', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('22', '20', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('23', '21', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('24', '22', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('25', '23', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('26', '24', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('27', '25', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('28', '26', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('29', '27', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('30', '28', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('31', '29', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('32', '30', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('33', '31', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('34', '32', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('36', '1', '1');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('49', '6', '3');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('53', '8', '3');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('55', '7', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('56', '33', '3');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('57', '34', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('59', '35', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('60', '36', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('61', '37', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('62', '38', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('63', '39', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('64', '40', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('65', '41', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('66', '42', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('67', '43', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('68', '44', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('69', '45', '5');


