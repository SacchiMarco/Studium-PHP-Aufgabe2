/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : ws_webshop

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-07-12 00:29:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ws_artikel`
-- ----------------------------
DROP TABLE IF EXISTS `ws_artikel`;
CREATE TABLE `ws_artikel` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `a_artikelnr` int(10) unsigned NOT NULL,
  `a_name` varchar(40) NOT NULL,
  `a_preis` decimal(6,2) unsigned NOT NULL,
  `a_menge` int(11) DEFAULT NULL,
  `a_datum` date NOT NULL,
  PRIMARY KEY (`a_id`),
  UNIQUE KEY `a_artikelnr` (`a_artikelnr`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ws_artikel
-- ----------------------------
INSERT INTO `ws_artikel` VALUES ('1', '1001', 'Rock am Ring', '19.99', '70', '2015-07-12');
INSERT INTO `ws_artikel` VALUES ('2', '2002', 'Gurten Festival', '19.90', '40', '2015-08-28');
INSERT INTO `ws_artikel` VALUES ('3', '3003', 'Seenachtsfest', '25.90', '40', '2015-09-24');
INSERT INTO `ws_artikel` VALUES ('4', '4004', 'Openair Krachbum', '29.90', '50', '2015-09-09');
INSERT INTO `ws_artikel` VALUES ('5', '5005', 'Monsterkonzert', '45.50', '110', '2015-11-29');

-- ----------------------------
-- Table structure for `ws_bestellung`
-- ----------------------------
DROP TABLE IF EXISTS `ws_bestellung`;
CREATE TABLE `ws_bestellung` (
  `b_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `b_artikelnr` int(10) unsigned NOT NULL,
  `b_menge` int(10) unsigned NOT NULL DEFAULT '1',
  `b_kunde` int(10) unsigned NOT NULL,
  `b_zahlweise` enum('online','nachname','rechnung') DEFAULT 'online',
  PRIMARY KEY (`b_id`),
  KEY `b_kunde` (`b_kunde`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ws_bestellung
-- ----------------------------
INSERT INTO `ws_bestellung` VALUES ('2', '1001', '3', '1234', 'online');
INSERT INTO `ws_bestellung` VALUES ('3', '3003', '1', '1234', 'online');
INSERT INTO `ws_bestellung` VALUES ('4', '5005', '2', '1234', 'online');
INSERT INTO `ws_bestellung` VALUES ('5', '2002', '1', '40048', 'online');
INSERT INTO `ws_bestellung` VALUES ('6', '5005', '7', '40048', 'online');

-- ----------------------------
-- Table structure for `ws_kunden`
-- ----------------------------
DROP TABLE IF EXISTS `ws_kunden`;
CREATE TABLE `ws_kunden` (
  `k_kundennummer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `k_name` varchar(30) NOT NULL,
  `k_vorname` varchar(30) NOT NULL,
  `k_plz` varchar(6) NOT NULL,
  `k_ort` varchar(20) NOT NULL,
  `k_strasse` varchar(30) NOT NULL,
  `k_mail` varchar(30) NOT NULL,
  `k_passwort` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `k_kennung` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`k_kundennummer`),
  UNIQUE KEY `k_kennung` (`k_kennung`)
) ENGINE=InnoDB AUTO_INCREMENT=40050 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ws_kunden
-- ----------------------------
INSERT INTO `ws_kunden` VALUES ('40049', 'test', 'test', '1234', 'testort', 'testweg', 'ka@wo.da', '202cb962ac59075b964b07152d234b70', '123');

-- ----------------------------
-- Table structure for `ws_warenkorb`
-- ----------------------------
DROP TABLE IF EXISTS `ws_warenkorb`;
CREATE TABLE `ws_warenkorb` (
  `w_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `w_artikelnr` int(10) unsigned NOT NULL,
  `w_menge` int(10) unsigned NOT NULL DEFAULT '1',
  `w_kunde` int(10) unsigned NOT NULL,
  `w_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ws_warenkorb
-- ----------------------------
INSERT INTO `ws_warenkorb` VALUES ('12', '4004', '3', '40048', '2015-07-11 23:14:42');
INSERT INTO `ws_warenkorb` VALUES ('16', '5005', '1', '40048', '2015-07-11 23:14:41');
