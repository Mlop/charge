/*
Navicat MySQL Data Transfer

Source Server         : tmserver
Source Server Version : 50640
Source Host           : 119.27.163.89:3306
Source Database       : charge

Target Server Type    : MYSQL
Target Server Version : 50640
File Encoding         : 65001

Date: 2019-02-28 21:53:37
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', '4', '10000.00', '1', '47', '爸给豆豆压岁钱', 'income', '2019-02-04 00:00:00', '2019-02-27 23:32:46', '2019-02-27 23:32:46');
INSERT INTO `account` VALUES ('2', '4', '500.00', '1', '47', '小舅给豆豆压岁钱', 'income', '2019-02-06 00:00:00', '2019-02-27 23:33:33', '2019-02-27 23:33:33');
INSERT INTO `account` VALUES ('3', '4', '1000.00', '1', '47', '弟给豆豆', 'income', '2019-02-09 00:00:00', '2019-02-27 23:35:58', '2019-02-27 23:35:58');
INSERT INTO `account` VALUES ('4', '4', '1000.00', '1', '52', '给子研伟城红包', 'outgo', '2019-02-09 00:00:00', '2019-02-27 23:36:57', '2019-02-28 12:29:58');
INSERT INTO `account` VALUES ('5', '4', '400.00', '1', '47', '二舅给豆豆', 'income', '2019-02-06 00:00:00', '2019-02-28 11:24:51', '2019-02-28 11:24:51');
INSERT INTO `account` VALUES ('6', '4', '200.00', '1', '47', '二舅家表妹一给豆豆', 'income', '2019-02-06 00:00:00', '2019-02-28 11:26:30', '2019-02-28 11:26:30');
INSERT INTO `account` VALUES ('7', '4', '200.00', '1', '47', '二舅家表妹二给豆豆', 'income', '2019-02-06 00:00:00', '2019-02-28 11:26:38', '2019-02-28 11:26:38');
INSERT INTO `account` VALUES ('8', '4', '400.00', '1', '47', '大舅给豆豆', 'income', '2019-02-06 00:00:00', '2019-02-28 11:27:28', '2019-02-28 11:27:28');
INSERT INTO `account` VALUES ('9', '4', '100.00', '1', '47', '秀丽给豆豆', 'income', '2019-02-08 00:00:00', '2019-02-28 11:28:01', '2019-02-28 11:28:01');
INSERT INTO `account` VALUES ('10', '4', '200.00', '1', '47', '小叔给豆豆', 'income', '2019-02-08 00:00:00', '2019-02-28 11:28:24', '2019-02-28 11:28:24');
INSERT INTO `account` VALUES ('11', '4', '200.00', '1', '47', '小姨给豆豆', 'income', '2019-02-08 00:00:00', '2019-02-28 11:28:36', '2019-02-28 11:28:36');
INSERT INTO `account` VALUES ('12', '4', '200.00', '1', '47', '舅奶奶给豆豆', 'income', '2019-02-07 00:00:00', '2019-02-28 11:28:57', '2019-02-28 11:30:50');
INSERT INTO `account` VALUES ('13', '4', '200.00', '1', '47', '伯伯妈妈给豆豆', 'income', '2019-02-07 00:00:00', '2019-02-28 11:29:30', '2019-02-28 11:29:30');
INSERT INTO `account` VALUES ('14', '4', '100.00', '1', '3', '', 'outgo', '2019-02-28 00:00:00', '2019-02-28 13:14:35', '2019-02-28 13:14:35');
INSERT INTO `account` VALUES ('15', '4', '100.00', '1', '3', '', 'outgo', '2019-02-28 00:00:00', '2019-02-28 13:14:38', '2019-02-28 13:14:38');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES ('1', '日常账本', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of category_favorite
-- ----------------------------
INSERT INTO `category_favorite` VALUES ('13', '2', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('14', '3', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('15', '4', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('16', '10', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('17', '47', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('18', '48', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('19', '49', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('20', '50', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('21', '52', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('22', '53', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('23', '54', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
INSERT INTO `category_favorite` VALUES ('24', '55', '4', '2019-02-27 21:48:58', '2019-02-27 21:48:58');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'nancy', null, 'vera0228@sohu.com', '$2y$10$NO4uT5Fltnty4vGeHig0VOTMFg/PaWH0i007aCXvDluij.lzjHfne', '2019-02-27 20:51:00', '2019-02-27 20:51:00');
INSERT INTO `user` VALUES ('2', '1234', '1234', null, '$2y$10$c3nd.MiwTsRweq8d24CBDefVlMsqrCCF3ftXvWMM4QlErVzEry9KC', '2019-02-27 21:15:51', '2019-02-27 21:15:51');
INSERT INTO `user` VALUES ('4', 'zch', '18108147090', null, '$2y$10$jq3Pn4cESYn63slft6tUY../Fvl8Dpbw3o2UxBb890A66KlWZlvPO', '2019-02-27 21:48:58', '2019-02-27 21:48:58');
