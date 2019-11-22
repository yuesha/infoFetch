/*
 Navicat Premium Data Transfer

 Source Server         : 本机
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : infofetch

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 22/11/2019 22:23:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for classify
-- ----------------------------
DROP TABLE IF EXISTS `classify`;
CREATE TABLE `classify`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  `add_user` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `add_user`(`add_user`) USING BTREE,
  CONSTRAINT `classify_ibfk_1` FOREIGN KEY (`add_user`) REFERENCES `manage` (`name`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of classify
-- ----------------------------
INSERT INTO `classify` VALUES (1, '都市小说', 'admin', 1574347040);
INSERT INTO `classify` VALUES (2, '玄幻小说', 'admin', 1574347971);
INSERT INTO `classify` VALUES (3, '仙侠小说', 'admin', 1574348037);
INSERT INTO `classify` VALUES (4, '武侠小说', 'admin', 1574348130);
INSERT INTO `classify` VALUES (5, '言情小说', 'admin', 1574431905);
INSERT INTO `classify` VALUES (6, '测试分类2', 'admin', 1574431991);

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
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of manage
-- ----------------------------
INSERT INTO `manage` VALUES (2, 'admin', 'aa06e8be784bd7b4d30bf21fada8957c', 1573541726);

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of manage_log
-- ----------------------------
INSERT INTO `manage_log` VALUES (1, 2, '测试分类 分类添加成功', '127.0.0.1', 1574431905, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'测试分类\' , \'admin\' , 1574431905)');
INSERT INTO `manage_log` VALUES (2, 2, '测试分类1 分类添加成功', '127.0.0.1', 1574431991, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'测试分类1\' , \'admin\' , 1574431991)');
INSERT INTO `manage_log` VALUES (3, 2, '修改 测试分类1 分类名称为:测试分类2', '127.0.0.1', 1574432023, 'UPDATE `classify`  SET `name`=\'测试分类2\'  WHERE  `id` = 6');
INSERT INTO `manage_log` VALUES (4, 2, '修改 测试分类 分类名称为： 言情小说', '127.0.0.1', 1574432087, 'UPDATE `classify`  SET `name`=\'言情小说\'  WHERE  `id` = 5');

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
