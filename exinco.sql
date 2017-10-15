/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : exinco

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-10-15 19:33:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for exinco_callbake
-- ----------------------------
DROP TABLE IF EXISTS `exinco_callbake`;
CREATE TABLE `exinco_callbake` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CPParam` varchar(14) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `linkid` varchar(16) DEFAULT NULL,
  `codeid` int(7) DEFAULT NULL,
  `siteid` int(3) DEFAULT NULL,
  `channelid` int(3) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `sms_code` varchar(50) DEFAULT NULL,
  `login_port` varchar(10) DEFAULT NULL,
  `cb` tinyint(1) DEFAULT NULL,
  `cb_status` tinyint(1) DEFAULT NULL,
  `rtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_callbake
-- ----------------------------
INSERT INTO `exinco_callbake` VALUES ('1', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066573');
INSERT INTO `exinco_callbake` VALUES ('2', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066655');
INSERT INTO `exinco_callbake` VALUES ('3', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066656');
INSERT INTO `exinco_callbake` VALUES ('4', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066656');
INSERT INTO `exinco_callbake` VALUES ('5', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066657');
INSERT INTO `exinco_callbake` VALUES ('6', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066658');
INSERT INTO `exinco_callbake` VALUES ('7', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066704');
INSERT INTO `exinco_callbake` VALUES ('8', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066705');
INSERT INTO `exinco_callbake` VALUES ('9', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066706');
INSERT INTO `exinco_callbake` VALUES ('10', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066706');
INSERT INTO `exinco_callbake` VALUES ('11', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066707');
INSERT INTO `exinco_callbake` VALUES ('12', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066707');
INSERT INTO `exinco_callbake` VALUES ('13', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066708');
INSERT INTO `exinco_callbake` VALUES ('14', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066709');
INSERT INTO `exinco_callbake` VALUES ('15', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066709');
INSERT INTO `exinco_callbake` VALUES ('16', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066710');
INSERT INTO `exinco_callbake` VALUES ('17', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066711');
INSERT INTO `exinco_callbake` VALUES ('18', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066746');
INSERT INTO `exinco_callbake` VALUES ('19', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066747');
INSERT INTO `exinco_callbake` VALUES ('20', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066748');
INSERT INTO `exinco_callbake` VALUES ('21', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066749');
INSERT INTO `exinco_callbake` VALUES ('22', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066749');
INSERT INTO `exinco_callbake` VALUES ('23', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066750');
INSERT INTO `exinco_callbake` VALUES ('24', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066751');
INSERT INTO `exinco_callbake` VALUES ('25', '2147483647', '1', '0', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066751');
INSERT INTO `exinco_callbake` VALUES ('26', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066834');
INSERT INTO `exinco_callbake` VALUES ('27', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066835');
INSERT INTO `exinco_callbake` VALUES ('28', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066836');
INSERT INTO `exinco_callbake` VALUES ('29', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066837');
INSERT INTO `exinco_callbake` VALUES ('30', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066838');
INSERT INTO `exinco_callbake` VALUES ('31', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066839');
INSERT INTO `exinco_callbake` VALUES ('32', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066839');
INSERT INTO `exinco_callbake` VALUES ('33', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066840');
INSERT INTO `exinco_callbake` VALUES ('34', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066841');
INSERT INTO `exinco_callbake` VALUES ('35', '2147483647', '1', '2147483647', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066842');
INSERT INTO `exinco_callbake` VALUES ('36', '2147483647', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066930');
INSERT INTO `exinco_callbake` VALUES ('37', '2147483647', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066930');
INSERT INTO `exinco_callbake` VALUES ('38', '2147483647', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066931');
INSERT INTO `exinco_callbake` VALUES ('39', '2147483647', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066931');
INSERT INTO `exinco_callbake` VALUES ('40', '2147483647', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066932');
INSERT INTO `exinco_callbake` VALUES ('41', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066963');
INSERT INTO `exinco_callbake` VALUES ('42', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066963');
INSERT INTO `exinco_callbake` VALUES ('43', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '0', '0', '1508066964');
INSERT INTO `exinco_callbake` VALUES ('44', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066964');
INSERT INTO `exinco_callbake` VALUES ('45', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066965');
INSERT INTO `exinco_callbake` VALUES ('46', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066965');
INSERT INTO `exinco_callbake` VALUES ('47', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066966');
INSERT INTO `exinco_callbake` VALUES ('48', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066967');
INSERT INTO `exinco_callbake` VALUES ('49', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066968');
INSERT INTO `exinco_callbake` VALUES ('50', '10099123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508066968');
INSERT INTO `exinco_callbake` VALUES ('51', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '2147483647', 'sms_code', 'login_port', '1', '1', '1508067042');
INSERT INTO `exinco_callbake` VALUES ('52', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067080');
INSERT INTO `exinco_callbake` VALUES ('53', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067081');
INSERT INTO `exinco_callbake` VALUES ('54', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067081');
INSERT INTO `exinco_callbake` VALUES ('55', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '0', '0', '1508067082');
INSERT INTO `exinco_callbake` VALUES ('56', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067082');
INSERT INTO `exinco_callbake` VALUES ('57', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '0', '0', '1508067083');
INSERT INTO `exinco_callbake` VALUES ('58', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '0', '0', '1508067084');
INSERT INTO `exinco_callbake` VALUES ('59', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067084');
INSERT INTO `exinco_callbake` VALUES ('60', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067085');
INSERT INTO `exinco_callbake` VALUES ('61', '100123456789', '1', '1111111111111111', '1000123', '999', '100', '13910685349', 'sms_code', 'login_port', '1', '1', '1508067086');

-- ----------------------------
-- Table structure for exinco_channel
-- ----------------------------
DROP TABLE IF EXISTS `exinco_channel`;
CREATE TABLE `exinco_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(3) DEFAULT NULL,
  `channel_name` varchar(20) DEFAULT NULL,
  `mo` varchar(255) DEFAULT NULL,
  `mr` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cb` tinyint(1) DEFAULT NULL,
  `cbfail` tinyint(1) DEFAULT NULL,
  `dedup` tinyint(1) DEFAULT NULL,
  `lac` tinyint(1) DEFAULT NULL,
  `ip` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_channel
-- ----------------------------
INSERT INTO `exinco_channel` VALUES ('1', '100', '掌智ADA', 'http://xxx.xxx.com1', '', '', '1', '0', '1', '0', '0', '1', '0');
INSERT INTO `exinco_channel` VALUES ('2', '101', 'TEST', '1', '', '', '1', '0', '1', '0', '0', '1', '0');
INSERT INTO `exinco_channel` VALUES ('3', '102', 'test2', '2', '', '', '1', '0', '1', '0', '0', '1', '0');
INSERT INTO `exinco_channel` VALUES ('4', '103', 'dfds', '3', '', '', '1', '0', '1', '0', '0', '1', '0');
INSERT INTO `exinco_channel` VALUES ('5', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0');

-- ----------------------------
-- Table structure for exinco_code_limit
-- ----------------------------
DROP TABLE IF EXISTS `exinco_code_limit`;
CREATE TABLE `exinco_code_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_num` int(4) DEFAULT NULL,
  `begin_date` int(2) DEFAULT NULL,
  `end_date` int(2) DEFAULT NULL,
  `fee_limit` int(11) DEFAULT NULL,
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_code_limit
-- ----------------------------
INSERT INTO `exinco_code_limit` VALUES ('1', '1006', '1', '31', '1500000', '0');

-- ----------------------------
-- Table structure for exinco_code_sort
-- ----------------------------
DROP TABLE IF EXISTS `exinco_code_sort`;
CREATE TABLE `exinco_code_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) DEFAULT NULL,
  `parentid` int(2) DEFAULT NULL,
  `parentname` varchar(20) DEFAULT NULL,
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_code_sort
-- ----------------------------
INSERT INTO `exinco_code_sort` VALUES ('1', '音乐', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('2', 'PC', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('3', '动漫', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('4', 'DDO', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('5', '视频', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('6', '翼支付', '3', '电信', '0');
INSERT INTO `exinco_code_sort` VALUES ('7', '联通强联网', '2', '联通', '0');
INSERT INTO `exinco_code_sort` VALUES ('8', '普通移动', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('9', '短信类型', '4', '短信类型', '0');
INSERT INTO `exinco_code_sort` VALUES ('10', 'RDO', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('11', '普通联通', '2', '联通', '0');
INSERT INTO `exinco_code_sort` VALUES ('12', 'IVR', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('13', '短信指令RDO', '4', '短信类型', '0');
INSERT INTO `exinco_code_sort` VALUES ('14', 'MM', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('15', '安卓单机', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('16', '强联', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('17', '普通电信', '3', '电信', '0');
INSERT INTO `exinco_code_sort` VALUES ('18', '积分', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('19', '微信', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('20', '小额支付', '1', '移动', '0');
INSERT INTO `exinco_code_sort` VALUES ('21', '测试', '1', '移动', '1');

-- ----------------------------
-- Table structure for exinco_code_type
-- ----------------------------
DROP TABLE IF EXISTS `exinco_code_type`;
CREATE TABLE `exinco_code_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_num` int(3) NOT NULL,
  `code_sort` int(2) DEFAULT NULL,
  `code_name` varchar(255) DEFAULT NULL,
  `dis` tinyint(1) DEFAULT '1',
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_code_type
-- ----------------------------
INSERT INTO `exinco_code_type` VALUES ('1', '100', '1', '宜搜音乐', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('2', '101', '8', '211平台代码（联网）', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('3', '102', '8', '联动优势', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('4', '103', '3', '点之行动漫', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('5', '104', '3', '宜搜动漫', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('6', '105', '1', '1', '1', '1');
INSERT INTO `exinco_code_type` VALUES ('7', '105', '7', 'test', '0', '0');
INSERT INTO `exinco_code_type` VALUES ('8', '124', '8', '全真api', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('9', '158', '6', '创宏视讯', '1', '0');
INSERT INTO `exinco_code_type` VALUES ('10', '302', '7', '东硕联通', '1', '0');

-- ----------------------------
-- Table structure for exinco_game_info
-- ----------------------------
DROP TABLE IF EXISTS `exinco_game_info`;
CREATE TABLE `exinco_game_info` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `code_num` int(3) DEFAULT NULL,
  `game_name` varchar(20) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1020 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_game_info
-- ----------------------------
INSERT INTO `exinco_game_info` VALUES ('1001', '101', 'PC-异闻聊斋', '[{\"var1\":\"300\"}]', '1', '0');
INSERT INTO `exinco_game_info` VALUES ('1002', '102', '测试游戏', '[{\"var1\":\"1\"},{\"var2\":\"1\"},{\"var3\":\"1\"},{\"var4\":\"1\"},{\"var5\":\"1\"},{\"var6\":\"测试\"},{\"var7\":\"1\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1005', '102', '测试游戏2', '[{\"var1\":\"100\"},{\"var2\":\"web\"},{\"var3\":\"1\"},{\"var4\":\"1\"},{\"var5\":\"1\"},{\"var6\":\"1\"},{\"var7\":\"1\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1006', '124', '极速空战', '[{\"var1\":\"CUC\"},{\"var3\":\"CP0042\"},{\"var4\":\"1\"},{\"var9\":\"0\"}]', '1', '0');
INSERT INTO `exinco_game_info` VALUES ('1007', '124', '极速空战', '[{\"var1\":\"CNC\"},{\"var3\":\"CP0042\"},{\"var4\":\"1\"},{\"var9\":\"0\"}]', '1', '0');
INSERT INTO `exinco_game_info` VALUES ('1008', '124', '全真MM', '[{\"var1\":\"CMCC\"},{\"var3\":\"CP0042\"},{\"var4\":\"1\"},{\"var9\":\"0\"}]', '1', '0');
INSERT INTO `exinco_game_info` VALUES ('1009', '124', '极速空战', '[{\"var1\":\"CMCC\"},{\"var3\":\"CP0042\"},{\"var4\":\"12\"},{\"var9\":\"0\"}]', '1', '0');
INSERT INTO `exinco_game_info` VALUES ('1010', '101', '咪咕-神趣动漫', '[{\"var1\":\"644\"}]', '1', '0');
INSERT INTO `exinco_game_info` VALUES ('1011', '100', '1', '[{\"var1\":\"300\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1012', '100', '1', '[{\"var1\":\"300\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1013', '100', '1', '[{\"var1\":\"3000\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1014', '100', '1', '[{\"var1\":\"1\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1015', '100', '1', '[{\"id\":\"\"},{\"var1\":\"1\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1016', '100', '1', '[{\"id\":\"\"},{\"var1\":\"11\"},{\"del\":\"0\"}]', '0', '1');
INSERT INTO `exinco_game_info` VALUES ('1017', '100', '1', '[{\"id\":\"\"},{\"var1\":\"111\"},{\"del\":\"0\"}]', '0', '1');
INSERT INTO `exinco_game_info` VALUES ('1018', '100', '1', '[{\"var1\":\"\"}]', '1', '1');
INSERT INTO `exinco_game_info` VALUES ('1019', '100', '测试游戏', '[{\"var1\":\"300\"}]', '1', '0');

-- ----------------------------
-- Table structure for exinco_game_item
-- ----------------------------
DROP TABLE IF EXISTS `exinco_game_item`;
CREATE TABLE `exinco_game_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_num` int(3) DEFAULT NULL,
  `param_type` tinyint(1) DEFAULT NULL,
  `field_name` varchar(20) DEFAULT NULL,
  `param_remarks` varchar(20) DEFAULT NULL,
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_game_item
-- ----------------------------
INSERT INTO `exinco_game_item` VALUES ('1', '100', '1', 'var1', '渠道号（cp）', '0');
INSERT INTO `exinco_game_item` VALUES ('2', '100', '2', 'sms_code', '计费代码', '0');
INSERT INTO `exinco_game_item` VALUES ('3', '101', '1', 'var1', '业务类型', '0');
INSERT INTO `exinco_game_item` VALUES ('4', '101', '2', 'login_port', '备注信息', '0');
INSERT INTO `exinco_game_item` VALUES ('5', '101', '2', 'sms_code', 'sp分配的道具id', '0');
INSERT INTO `exinco_game_item` VALUES ('8', '102', '1', 'var1', '商户号', '0');
INSERT INTO `exinco_game_item` VALUES ('10', '102', '1', 'var2', '平台类型', '0');
INSERT INTO `exinco_game_item` VALUES ('11', '102', '1', 'var3', '商品信息', '0');
INSERT INTO `exinco_game_item` VALUES ('12', '102', '1', 'var4', '货币类型', '0');
INSERT INTO `exinco_game_item` VALUES ('13', '102', '1', 'var5', '银行类型', '0');
INSERT INTO `exinco_game_item` VALUES ('14', '102', '1', 'var6', '版本号', '0');
INSERT INTO `exinco_game_item` VALUES ('15', '102', '2', 'sms_code', '商品号', '0');
INSERT INTO `exinco_game_item` VALUES ('16', '102', '1', 'var7', '秘钥', '0');
INSERT INTO `exinco_game_item` VALUES ('17', '124', '1', 'var1', 'operator', '0');
INSERT INTO `exinco_game_item` VALUES ('18', '124', '1', 'var3', 'cpid', '0');
INSERT INTO `exinco_game_item` VALUES ('19', '124', '1', 'var4', 'gameNo', '0');
INSERT INTO `exinco_game_item` VALUES ('20', '124', '1', 'var9', '是否是包月(1:是  0:否)', '0');
INSERT INTO `exinco_game_item` VALUES ('21', '103', '1', 'va1', '合作ID', '0');

-- ----------------------------
-- Table structure for exinco_item_info
-- ----------------------------
DROP TABLE IF EXISTS `exinco_item_info`;
CREATE TABLE `exinco_item_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_num` int(1) NOT NULL,
  `item_num` int(7) NOT NULL,
  `item_name` varchar(20) NOT NULL,
  `param` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_item_info
-- ----------------------------
INSERT INTO `exinco_item_info` VALUES ('1', '1001', '1001001', '100元宝', '[{\"login_port\":\"531\"},{\"sms_code\":\"237101\"}]', '100', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('2', '1001', '1001002', '200元宝', '[{\"login_port\":\"531\"},{\"sms_code\":\"237102\"}]', '200', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('3', '1001', '1001003', '300元宝', '[{\"login_port\":\"531\"},{\"sms_code\":\"237103\"}]', '300', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('4', '1010', '1010001', '0.5元', '[{\"login_port\":\"808\"},{\"sms_code\":\"2421001\"}]', '50', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('6', '1009', '1009001', '寻宝礼包', '\"\"', '1000', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('7', '1009', '1', '1', '\"\"', '1', '1', '1');
INSERT INTO `exinco_item_info` VALUES ('8', '1008', '1008001', '测试道具', '\"\"', '1000', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('9', '1007', '1007001', '测试道具', '\"\"', '2000', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('10', '1006', '1', '1', '\"\"', '1', '1', '1');
INSERT INTO `exinco_item_info` VALUES ('11', '1006', '1006001', '测试道具', '\"\"', '200', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('12', '1006', '1006002', '无敌护盾', '\"\"', '400', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('13', '1006', '1006003', '火箭弹', '\"\"', '600', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('14', '1006', '1006004', '火凤凰战机', '\"\"', '800', '1', '0');
INSERT INTO `exinco_item_info` VALUES ('15', '19', '19001', '测试道具', '[{\"sms_code\":\"dm\"}]', '100', '1', '0');

-- ----------------------------
-- Table structure for exinco_param_type
-- ----------------------------
DROP TABLE IF EXISTS `exinco_param_type`;
CREATE TABLE `exinco_param_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param_name` varchar(10) DEFAULT NULL,
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_param_type
-- ----------------------------
INSERT INTO `exinco_param_type` VALUES ('1', '游戏', '0');
INSERT INTO `exinco_param_type` VALUES ('2', '道具', '0');

-- ----------------------------
-- Table structure for exinco_requests
-- ----------------------------
DROP TABLE IF EXISTS `exinco_requests`;
CREATE TABLE `exinco_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(3) DEFAULT NULL,
  `siteid` int(3) DEFAULT NULL,
  `channelid` int(3) DEFAULT NULL,
  `codeid` int(7) DEFAULT NULL,
  `serial` varchar(12) DEFAULT NULL,
  `imsi` varchar(15) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `ib` tinyint(1) DEFAULT NULL,
  `hRet` int(4) DEFAULT NULL,
  `ptime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_requests
-- ----------------------------
INSERT INTO `exinco_requests` VALUES ('1', '1', '1', null, '1', '1', '1', '1', '1', null, null);
INSERT INTO `exinco_requests` VALUES ('2', '393', '100', '100', '1000', '123456789012', 'imsi', 'imei', '0', null, null);
INSERT INTO `exinco_requests` VALUES ('3', '393', '100', '100', '1000', '123456789012', 'imsi', 'imei', '0', null, '1508056040');
INSERT INTO `exinco_requests` VALUES ('4', '393', '123', '100', '1000', '123456789012', 'imsi', 'imei', '0', null, '1508056328');
INSERT INTO `exinco_requests` VALUES ('5', '393', '123', '100', '1000', '123456789012', 'imsi', 'imei', '0', null, '1508058120');
INSERT INTO `exinco_requests` VALUES ('6', '393', '123', '100', '1000', '123456789012', 'imsi', 'imei', '0', null, '1508058327');
INSERT INTO `exinco_requests` VALUES ('7', '393', '123', '100', '1000', '123456789012', 'imsi', 'imei', '0', null, '1508058591');
INSERT INTO `exinco_requests` VALUES ('8', '393', '123', '100', '1000', '123456789012', 'imsi', 'imei', '0', '203', '1508059428');

-- ----------------------------
-- Table structure for exinco_users
-- ----------------------------
DROP TABLE IF EXISTS `exinco_users`;
CREATE TABLE `exinco_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(12) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0 已删除 1 正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exinco_users
-- ----------------------------
INSERT INTO `exinco_users` VALUES ('1', '13910685349', 'eyJpdiI6InJONE53N2N2NVF1d1B2b0tZR1wvWSt3PT0iLCJ2YWx1ZSI6ImdDUTE5VzJJTjg5SVBlK1FDU290M2c9PSIsIm1hYyI6ImQ5NTVlYjJmNzczZDZmZjllMGZhMGVhMDdhM2M2OTU1MDEyNDI3MDhlYjQwNzg4OTU3MTM1YTdlNmU1ZWNlOTUifQ==', '吕雷', '1');
