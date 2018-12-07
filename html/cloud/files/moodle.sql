/*
 Navicat MySQL Data Transfer

 Source Server         : test
 Source Server Type    : MySQL
 Source Server Version : 50637
 Source Host           : localhost:3306
 Source Schema         : moodle

 Target Server Type    : MySQL
 Target Server Version : 50637
 File Encoding         : 65001

 Date: 28/08/2017 12:23:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for qwerty
-- ----------------------------
DROP TABLE IF EXISTS `qwerty`;
CREATE TABLE `qwerty`  (
  `qwerty` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
