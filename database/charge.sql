/*
Navicat MySQL Data Transfer

Source Server         : localhost_account
Source Server Version : 50724
Source Host           : 127.0.0.1:3306
Source Database       : charge

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-02-27 20:13:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `cash` decimal(10,2) DEFAULT NULL,
  `book_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('loan','income','outgo') COLLATE utf8mb4_unicode_ci DEFAULT 'outgo',
  `record_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of account
-- ----------------------------

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of book
-- ----------------------------

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('loan','outgo','in','out','income') COLLATE utf8mb4_unicode_ci DEFAULT 'in',
  `parent_category_id` int(10) unsigned DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '餐饮', 'outgo', '0', null, '2019-02-27 19:36:22', '2019-02-27 19:36:22');
INSERT INTO `category` VALUES ('2', '早餐', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('3', '午餐', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('4', '晚餐', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('5', '饮料水果', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('6', '买菜原料', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('7', '油盐酱醋', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('8', '餐饮其他', 'outgo', '1', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('9', '交通', 'outgo', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('10', '打车', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('11', '加油', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('12', '停车费', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('13', '火车', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('14', '长途汽车', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('15', '公交', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('16', '地铁', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('17', '交通其他', 'outgo', '9', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('18', '购物', 'outgo', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('19', '服装鞋包', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('20', '家居百货', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('21', '宝宝用品', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('22', '烟酒', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('23', '电子数码', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('24', '报刊书籍', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('25', '电器', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('26', '购物其他', 'outgo', '18', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('27', '娱乐', 'outgo', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('28', '旅游度假', 'outgo', '27', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('29', '电影', 'outgo', '27', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('30', '运动健身', 'outgo', '27', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('31', '花鸟宠物', 'outgo', '27', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('32', '聚会玩乐', 'outgo', '27', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('33', '娱乐其他', 'outgo', '27', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('34', '居家', 'outgo', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('35', '手机电话', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('36', '水电燃气', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('37', '生活费', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('38', '房款房贷', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('39', '快递邮政', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('40', '物业', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('41', '消费贷款', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('42', '生活其他', 'outgo', '34', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('43', '人情', 'outgo', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('44', '礼金红包', 'outgo', '43', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('45', '物品', 'outgo', '43', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('46', '人情其他', 'outgo', '43', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('47', '红包', 'income', '0', null, '2019-02-27 19:43:41', '2019-02-27 19:43:41');
INSERT INTO `category` VALUES ('48', '工资薪水', 'income', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('49', '营业收入', 'income', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('50', '奖金', 'income', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('51', '其他', 'income', '0', null, '2019-02-27 19:33:47', '2019-02-27 19:33:47');
INSERT INTO `category` VALUES ('52', '借入', 'loan', '0', null, '2019-02-13 11:52:53', '2019-02-13 11:52:53');
INSERT INTO `category` VALUES ('53', '借出', 'loan', '0', null, '2019-02-13 11:52:53', '2019-02-13 11:52:53');
INSERT INTO `category` VALUES ('54', '还款', 'loan', '0', null, '2019-02-13 11:52:53', '2019-02-13 11:52:53');
INSERT INTO `category` VALUES ('55', '收款', 'loan', '0', null, '2019-02-13 11:52:53', '2019-02-13 11:52:53');

-- ----------------------------
-- Table structure for category_favorite
-- ----------------------------
DROP TABLE IF EXISTS `category_favorite`;
CREATE TABLE `category_favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_favorite_unique_category_id_user_id` (`category_id`,`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of category_favorite
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
