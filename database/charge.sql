/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50724
Source Host           : 127.0.0.1:3306
Source Database       : charge

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-02-13 18:21:30
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES ('2', '豆豆', '14', '2019-02-13 17:45:53', '2019-02-13 17:45:53');
INSERT INTO `book` VALUES ('4', '豆豆红包', '14', '2019-02-13 17:50:56', '2019-02-13 17:50:56');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('loan','out','in') COLLATE utf8mb4_unicode_ci DEFAULT 'in',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `parent_category_id` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '餐饮', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('2', '早餐', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('3', '午餐', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('4', '晚餐', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('5', '饮料水果', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('6', '买菜原料', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('7', '油盐酱醋', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('8', '餐饮其他', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '1');
INSERT INTO `category` VALUES ('9', '交通', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('10', '打车', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('11', '加油', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('12', '停车费', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('13', '火车', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('14', '长途汽车', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('15', '公交', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('16', '地铁', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('17', '交通其他', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '9');
INSERT INTO `category` VALUES ('18', '购物', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('19', '服装鞋包', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('20', '家居百货', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('21', '宝宝用品', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('22', '烟酒', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('23', '电子数码', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('24', '报刊书籍', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('25', '电器', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('26', '购物其他', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '18');
INSERT INTO `category` VALUES ('27', '娱乐', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('28', '旅游度假', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '27');
INSERT INTO `category` VALUES ('29', '电影', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '27');
INSERT INTO `category` VALUES ('30', '运动健身', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '27');
INSERT INTO `category` VALUES ('31', '花鸟宠物', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '27');
INSERT INTO `category` VALUES ('32', '聚会玩乐', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '27');
INSERT INTO `category` VALUES ('33', '娱乐其他', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '27');
INSERT INTO `category` VALUES ('34', '居家', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('35', '手机电话', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('36', '水电燃气', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('37', '生活费', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('38', '房款房贷', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('39', '快递邮政', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('40', '物业', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('41', '消费贷款', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('42', '生活其他', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '34');
INSERT INTO `category` VALUES ('43', '人情', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('44', '礼金红包', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '43');
INSERT INTO `category` VALUES ('45', '物品', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '43');
INSERT INTO `category` VALUES ('46', '人情其他', 'out', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '43');
INSERT INTO `category` VALUES ('47', '红包', 'in', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('48', '工资薪水', 'in', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('49', '营业收入', 'in', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('50', '奖金', 'in', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('51', '其他', 'in', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('52', '借入', 'loan', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('53', '借出', 'loan', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('54', '还款', 'loan', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');
INSERT INTO `category` VALUES ('55', '收款', 'loan', '2019-02-13 11:52:53', '2019-02-13 11:52:53', '0');

-- ----------------------------
-- Table structure for income
-- ----------------------------
DROP TABLE IF EXISTS `income`;
CREATE TABLE `income` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `book_id` int(10) unsigned DEFAULT NULL,
  `cash` decimal(10,2) DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of income
-- ----------------------------
INSERT INTO `income` VALUES ('4', '14', '2', '20.30', '5', null, '2019-02-13 17:59:44', '2019-02-13 17:59:44');
INSERT INTO `income` VALUES ('5', '14', '2', '50.30', '5', null, '2019-02-13 18:00:16', '2019-02-13 18:00:16');

-- ----------------------------
-- Table structure for outgo
-- ----------------------------
DROP TABLE IF EXISTS `outgo`;
CREATE TABLE `outgo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `cash` decimal(10,2) DEFAULT NULL,
  `book_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of outgo
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'vera', null, 'vera0228@sohu.com', null, '$2y$10$mMm0yhuvdI7xDVuXgFBTOeYzlIXBmA04PLvDdLK.wz.171WMcDZ9K', null, 'U9lREUtPNN6qSnjUSzk6ePLawyFtXUIfAKWioE2DwfkIvdJiORuytx5v1yuX', '2018-11-09 17:11:33', '2018-11-12 19:35:12');
INSERT INTO `user` VALUES ('6', 'fish', '11115', 'aa@sohu.com', null, '$2y$10$Atlr.6VPisqSI4Fk1mZnZOysiPRk8mp5xWxBlF/g25/gK22b6Pkre', null, 'rqPcGfEJEZlEG0QvMj8rx4WwQvhsuoNCxgvhap5tR4CqSKjrdCAttWBRNB1x', '2018-11-12 01:50:09', '2018-11-16 06:08:50');
INSERT INTO `user` VALUES ('14', 'qAhO8t', null, 'nancy@aa.com', null, '$2y$10$PfyB07gENJDefSu73GyyMu3jE5Qfaun0IaxkuVy81/AiMuXDYh5pG', null, null, '2019-02-13 17:13:08', '2019-02-13 17:13:08');
