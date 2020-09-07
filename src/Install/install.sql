/*

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : v2_admin

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 07/09/2020 21:51:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_menu` VALUES (1, 0, 0, '首页', 'el-icon-monitor', '/admin/home/main', NULL, NULL, '2020-09-07 21:45:47');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '系统', 'el-icon-setting', 'system', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (3, 2, 3, '管理员', 'fa-ban', '/admin/users/list', NULL, NULL, '2020-09-07 13:28:09');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色', 'fa-ban', '/admin/roles/list', NULL, NULL, '2020-09-07 13:27:47');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限', 'fa-ban', '/admin/permissions/list', NULL, NULL, '2020-09-07 09:31:45');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单', 'fa-bars', '/admin/menu/list', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (7, 2, 7, '操作日志', 'fa-ban', '/admin/logs/list', NULL, NULL, '2020-09-07 09:31:54');
INSERT INTO `admin_menu` VALUES (9, 0, 1, '页面布局', 'el-icon-orange', '/demo/index', '[]', '2020-09-07 16:57:51', '2020-09-07 16:57:51');
INSERT INTO `admin_menu` VALUES (10, 0, 1, '各种表单', 'el-icon-s-platform', '/form/create', '[]', '2020-09-07 17:18:04', '2020-09-07 17:18:40');
INSERT INTO `admin_menu` VALUES (11, 0, 1, '各种按钮', 'el-icon-switch-button', '/button/index', '[]', '2020-09-07 17:39:37', '2020-09-07 17:39:37');
INSERT INTO `admin_menu` VALUES (12, 0, 1, 'alert警告', 'el-icon-alarm-clock', '/alert/index', '[]', '2020-09-07 17:44:14', '2020-09-07 17:44:14');
INSERT INTO `admin_menu` VALUES (13, 0, 1, '树状', 'el-icon-ice-cream-square', '/form/tree', '[]', '2020-09-07 19:48:24', '2020-09-07 19:48:24');
COMMIT;

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_operation_log
-- ----------------------------
BEGIN;
INSERT INTO `admin_operation_log` VALUES (2, 1, 'admin-api', 'GET', '127.0.0.1', '[]', '2020-09-03 16:20:28', '2020-09-03 16:20:28');
INSERT INTO `admin_operation_log` VALUES (3, 1, 'admin-api/auth/users', 'GET', '127.0.0.1', '[]', '2020-09-03 16:20:32', '2020-09-03 16:20:32');
INSERT INTO `admin_operation_log` VALUES (4, 1, 'admin-api/auth/users', 'GET', '127.0.0.1', '{\"get_data\":\"true\",\"page\":\"1\",\"per_page\":\"10\",\"sort_prop\":\"id\",\"sort_order\":\"asc\",\"sort_field\":\"id\"}', '2020-09-03 16:20:32', '2020-09-03 16:20:32');
INSERT INTO `admin_operation_log` VALUES (5, 1, 'admin-api/auth/permissions', 'GET', '127.0.0.1', '[]', '2020-09-03 16:20:32', '2020-09-03 16:20:32');
INSERT INTO `admin_operation_log` VALUES (6, 1, 'admin-api/auth/permissions', 'GET', '127.0.0.1', '{\"get_data\":\"true\",\"page\":\"1\",\"per_page\":\"15\",\"sort_prop\":\"id\",\"sort_order\":\"asc\",\"sort_field\":\"id\"}', '2020-09-03 16:20:32', '2020-09-03 16:20:32');
INSERT INTO `admin_operation_log` VALUES (7, 1, 'admin-api/auth/menu', 'GET', '127.0.0.1', '[]', '2020-09-03 16:20:33', '2020-09-03 16:20:33');
INSERT INTO `admin_operation_log` VALUES (8, 1, 'admin-api/auth/menu', 'GET', '127.0.0.1', '{\"get_data\":\"true\",\"page\":\"1\",\"per_page\":\"15\",\"sort_prop\":\"order\",\"sort_order\":\"asc\",\"sort_field\":\"order\"}', '2020-09-03 16:20:33', '2020-09-03 16:20:33');
INSERT INTO `admin_operation_log` VALUES (9, 1, 'admin-api/auth/logs', 'GET', '127.0.0.1', '[]', '2020-09-03 16:20:34', '2020-09-03 16:20:34');
INSERT INTO `admin_operation_log` VALUES (10, 1, 'admin-api/auth/logs', 'GET', '127.0.0.1', '{\"get_data\":\"true\",\"page\":\"1\",\"per_page\":\"15\",\"sort_prop\":\"id\",\"sort_order\":\"desc\",\"sort_field\":\"id\"}', '2020-09-03 16:20:34', '2020-09-03 16:20:34');
INSERT INTO `admin_operation_log` VALUES (11, 1, 'admin-api/auth/users', 'GET', '127.0.0.1', '{\"get_data\":\"true\",\"page\":\"1\",\"per_page\":\"10\",\"sort_prop\":\"id\",\"sort_order\":\"asc\",\"sort_field\":\"id\"}', '2020-09-03 16:20:37', '2020-09-03 16:20:37');
COMMIT;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_permissions` VALUES (1, '所有权限', '*', '[\"*\"]', NULL, '2020-09-07 16:32:51');
INSERT INTO `admin_permissions` VALUES (2, '首页', 'dashboard', '[\"GET::\\/admin\\/home\\/*\",\"GET::\\/admin\\/home\\/main\"]', NULL, '2020-09-07 16:33:03');
INSERT INTO `admin_permissions` VALUES (3, '登录/退出', 'auth.login', '[\"GET::\\/admin\\/logs\\/*\",\"GET::\\/admin\\/logs\\/create\"]', NULL, '2020-09-07 16:43:09');
INSERT INTO `admin_permissions` VALUES (5, '系统设置', 'auth.management', '[\"GET::\\/swagger\\/*\",\"GET::\\/swagger\",\"GET::\\/index\\/list\",\"GET::\\/index\\/*\"]', NULL, '2020-09-07 16:42:55');
COMMIT;

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (1, 8, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (1, 14, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 1, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 2, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (1, 2, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (1, 3, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (1, 5, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);
INSERT INTO `admin_role_users` VALUES (1, 2, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
BEGIN;
INSERT INTO `admin_roles` VALUES (1, '超级管理员', 'administrator', '2020-09-03 16:19:02', '2020-09-03 16:19:02');
COMMIT;

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_user_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_user_permissions` VALUES (2, 1, NULL, NULL);
INSERT INTO `admin_user_permissions` VALUES (1, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$Sw7R0JYnA0DV/7fpo1HMfOR4gU6QiexaY3oFKMJIx6fTJbjl5esXO', '管理员', 'https://gw.alipayobjects.com/zos/antfincdn/XAosXuNZyF/BiazfanxmamNRoxxVxka.png', 'Uh5tXnhDocmTgAApkpyIMMEXsUQCxKUUh9LeULMHYW8alxpv3OtrUDptkfVx', '2020-09-03 16:19:02', '2020-09-07 13:30:29');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
