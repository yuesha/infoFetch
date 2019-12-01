/*
 Navicat Premium Data Transfer

 Source Server         : 云
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : 122.51.76.233:3306
 Source Schema         : infoFetch

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 01/12/2019 10:14:54
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
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of classify
-- ----------------------------
INSERT INTO `classify` VALUES (17, '都市小说', 'admin', 1575125734);
INSERT INTO `classify` VALUES (18, '言情小说', 'admin', 1575125754);
INSERT INTO `classify` VALUES (19, '历史小说', 'admin', 1575125763);
INSERT INTO `classify` VALUES (20, '个人博客', 'admin', 1575125780);
INSERT INTO `classify` VALUES (21, '科幻小说', 'admin', 1575125804);
INSERT INTO `classify` VALUES (22, '灵异小说', 'admin', 1575125815);

-- ----------------------------
-- Table structure for fetch_pool
-- ----------------------------
DROP TABLE IF EXISTS `fetch_pool`;
CREATE TABLE `fetch_pool`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classify_id` int(11) NULL DEFAULT 0 COMMENT '分类id',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '地址池名称',
  `auto_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '目录地址',
  `auto_rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '目录抓取规则（JSON）',
  `default_rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '默认抓取规则（json）',
  `is_auto` int(1) NOT NULL COMMENT '是否为自动抓取',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `add_user` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
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
  `add_user` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
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
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `add_user` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
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
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `add_user` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of manage
-- ----------------------------
INSERT INTO `manage` VALUES (3, 'admin', 'aa06e8be784bd7b4d30bf21fada8957c', NULL, NULL);

-- ----------------------------
-- Table structure for manage_log
-- ----------------------------
DROP TABLE IF EXISTS `manage_log`;
CREATE TABLE `manage_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manage_id` int(11) NOT NULL COMMENT '管理员id',
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ip地址',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `add_user` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `sql` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '操作sql语句',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `manage_id`(`manage_id`) USING BTREE,
  CONSTRAINT `manage_log_ibfk_1` FOREIGN KEY (`manage_id`) REFERENCES `manage` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of manage_log
-- ----------------------------
INSERT INTO `manage_log` VALUES (15, 3, '登录成功', '112.96.109.176', NULL, NULL, '无');
INSERT INTO `manage_log` VALUES (16, 3, '都市小说 分类添加成功', '112.96.109.176', NULL, NULL, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'都市小说\' , \'admin\' , 1575125734)');
INSERT INTO `manage_log` VALUES (17, 3, '言情小说 分类添加成功', '112.96.109.176', NULL, NULL, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'言情小说\' , \'admin\' , 1575125754)');
INSERT INTO `manage_log` VALUES (18, 3, '历史小说 分类添加成功', '112.96.109.176', NULL, NULL, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'历史小说\' , \'admin\' , 1575125763)');
INSERT INTO `manage_log` VALUES (19, 3, '个人博客 分类添加成功', '112.96.109.176', NULL, NULL, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'个人博客\' , \'admin\' , 1575125780)');
INSERT INTO `manage_log` VALUES (20, 3, '科幻小说 分类添加成功', '112.96.109.176', NULL, NULL, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'科幻小说\' , \'admin\' , 1575125804)');
INSERT INTO `manage_log` VALUES (21, 3, '灵异小说 分类添加成功', '112.96.109.176', NULL, NULL, 'INSERT INTO `classify` (`name` , `add_user` , `created_at`) VALUES (\'灵异小说\' , \'admin\' , 1575125815)');

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
