/*
 Navicat Premium Data Transfer

 Source Server         : 4-虚拟机
 Source Server Type    : MySQL
 Source Server Version : 50645
 Source Host           : 192.168.13.4:3306
 Source Schema         : infoFetch

 Target Server Type    : MySQL
 Target Server Version : 50645
 File Encoding         : 65001

 Date: 13/09/2019 15:35:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fetch_pool
-- ----------------------------
DROP TABLE IF EXISTS `fetch_pool`;
CREATE TABLE `fetch_pool`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '地址池名称',
  `auto_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '目录地址',
  `default_rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '默认抓取规则（json）',
  `is_auto` int(1) NOT NULL COMMENT '是否为自动抓取',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for fetch_url
-- ----------------------------
DROP TABLE IF EXISTS `fetch_url`;
CREATE TABLE `fetch_url`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fetch_pool_id` int(11) NOT NULL COMMENT '地址池id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `url` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '抓取地址',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '指定抓取规则',
  `is_fetch` int(1) NOT NULL COMMENT '抓取标识位',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fetch_pool_id`(`fetch_pool_id`) USING BTREE,
  CONSTRAINT `fetch_url_ibfk_1` FOREIGN KEY (`fetch_pool_id`) REFERENCES `fetch_pool` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for fetched_info
-- ----------------------------
DROP TABLE IF EXISTS `fetched_info`;
CREATE TABLE `fetched_info`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fetch_pool_id` int(11) NOT NULL COMMENT '地址池id',
  `fetch_url_id` int(11) NOT NULL COMMENT '对应的抓取记录id',
  `main` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '抓取内容',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fetch_pool_id`(`fetch_pool_id`) USING BTREE,
  INDEX `fetch_url_id`(`fetch_url_id`) USING BTREE,
  CONSTRAINT `fetched_info_ibfk_1` FOREIGN KEY (`fetch_pool_id`) REFERENCES `fetch_pool` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fetched_info_ibfk_2` FOREIGN KEY (`fetch_url_id`) REFERENCES `fetch_url` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for manage
-- ----------------------------
DROP TABLE IF EXISTS `manage`;
CREATE TABLE `manage`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理用户名',
  `pw` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for manage_log
-- ----------------------------
DROP TABLE IF EXISTS `manage_log`;
CREATE TABLE `manage_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manage_id` int(11) NOT NULL COMMENT '管理员id',
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ip地址',
  `created_at` int(11) NOT NULL COMMENT '操作时间',
  `sql` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '操作sql语句',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `manage_id`(`manage_id`) USING BTREE,
  CONSTRAINT `manage_log_ibfk_1` FOREIGN KEY (`manage_id`) REFERENCES `manage` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for show_setting
-- ----------------------------
DROP TABLE IF EXISTS `show_setting`;
CREATE TABLE `show_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fetch_pool_id` int(11) NOT NULL COMMENT '地址池id',
  `bg_color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '背景颜色',
  `bg_image_src` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '背景图片地址',
  `main_fontsize` int(2) NULL DEFAULT NULL COMMENT '正文字体大小',
  `title_fintsize` int(2) NULL DEFAULT NULL COMMENT '标题字体大小',
  `font_family` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字体',
  `line_spacing` int(3) NULL DEFAULT NULL COMMENT '行间距',
  `word_spacing` int(3) NULL DEFAULT NULL COMMENT '字间距',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fetch_pool_id`(`fetch_pool_id`) USING BTREE,
  CONSTRAINT `show_setting_ibfk_1` FOREIGN KEY (`fetch_pool_id`) REFERENCES `fetch_pool` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
