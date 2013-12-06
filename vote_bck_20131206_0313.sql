-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.63-0ubuntu0.10.04.1


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema vote
--

CREATE DATABASE IF NOT EXISTS vote;
USE vote;
CREATE TABLE  `vote`.`v_answer` (
  `a_id` int(10) unsigned NOT NULL,
  `a_question` int(10) unsigned NOT NULL DEFAULT '0',
  `a_answer` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`a_id`) USING BTREE,
  KEY `FK_v_answer_to_question` (`a_question`),
  CONSTRAINT `FK_v_answer_to_question` FOREIGN KEY (`a_question`) REFERENCES `v_question` (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Answers to questions.';
INSERT INTO `vote`.`v_answer` VALUES  (1,1,'daily'),
 (2,1,'once a week or more'),
 (3,1,'2 to 3 times a month'),
 (4,1,'once/month'),
 (5,1,'every 2-3 months'),
 (6,1,'2-3 times a year'),
 (7,2,'very unsatisfied'),
 (8,2,'unsatisfied'),
 (10,2,'somewhat satisfied'),
 (11,2,'very satisfied'),
 (12,2,'extremely satisfied'),
 (13,3,'definitely'),
 (14,3,'probably'),
 (15,3,'might or might not'),
 (16,3,'probably not'),
 (17,3,'definitely not'),
 (18,5,'Bristol, UK'),
 (19,5,'London, UK'),
 (20,5,'Boston, MA'),
 (21,5,'New York, NY'),
 (22,7,'Hamburger'),
 (23,7,'French fries'),
 (24,7,'Pizza'),
 (25,7,'Salad'),
 (26,7,'Ice cream'),
 (27,7,'Coffee/tea'),
 (28,7,'Soft drink'),
 (29,7,'Other'),
 (30,8,'under 18'),
 (31,8,'18-24'),
 (32,8,'25-34'),
 (33,8,'35-44'),
 (34,8,'45-54'),
 (35,8,'55+'),
 (36,10,'Yes'),
 (37,10,'No'),
 (38,11,'under 1 year'),
 (39,11,'1 to 2 years'),
 (40,11,'3 to 5 years'),
 (41,11,'6 to 10 years'),
 (42,11,'more than 10 years'),
 (43,12,'Yes'),
 (44,12,'No'),
 (45,14,'Gym'),
 (46,14,'Sauna'),
 (47,14,'Massages'),
 (48,14,'Bioresonance'),
 (49,4,'VOTE_RAW'),
 (50,6,'VOTE_RAW'),
 (51,9,'VOTE_RAW'),
 (52,13,'VOTE_RAW');
CREATE TABLE  `vote`.`v_answer_data` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_survey_data` int(10) unsigned NOT NULL DEFAULT '0',
  `ad_answer` int(10) unsigned DEFAULT '0',
  `ad_raw_answer` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`ad_id`),
  KEY `FK_v_answer_data_to_survey_data` (`ad_survey_data`),
  KEY `FK_v_answer_data_to_answer` (`ad_answer`),
  CONSTRAINT `FK_v_answer_data_to_answer` FOREIGN KEY (`ad_answer`) REFERENCES `v_answer` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_v_answer_data_to_survey_data` FOREIGN KEY (`ad_survey_data`) REFERENCES `v_survey_data` (`sd_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='Real data (item) which represent(s) single user answer.';
INSERT INTO `vote`.`v_answer_data` VALUES  (1,1,1,NULL),
 (2,1,12,NULL),
 (3,1,13,NULL),
 (4,1,49,'I would prefer white colour to yellow colour.'),
 (5,2,21,NULL),
 (6,2,6,'2013-01-01 12:00:00'),
 (7,2,26,NULL),
 (8,2,27,NULL),
 (9,2,28,NULL),
 (10,2,31,NULL),
 (11,2,51,'Yes. It took too long for a waiter to come. Dough!'),
 (12,3,36,NULL),
 (13,3,38,NULL),
 (14,3,43,NULL),
 (15,3,52,'julia.wallner@gmx.at');
CREATE TABLE  `vote`.`v_keyword` (
  `k_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `k_name` varchar(16) NOT NULL DEFAULT '',
  `k_survey` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`k_id`,`k_name`),
  KEY `FK_v_keyword_to_survey` (`k_survey`),
  CONSTRAINT `FK_v_keyword_to_survey` FOREIGN KEY (`k_survey`) REFERENCES `v_survey` (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Survey keywords.';
INSERT INTO `vote`.`v_keyword` VALUES  (1,'product',1),
 (2,'satisfaction',1),
 (3,'crocodile',2),
 (4,'cafe',2),
 (5,'eat&drink',2),
 (6,'pool',3),
 (7,'membership',3),
 (8,'product',3);
CREATE TABLE  `vote`.`v_question` (
  `q_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `q_survey` int(10) unsigned NOT NULL DEFAULT '0',
  `q_type` int(10) unsigned NOT NULL DEFAULT '0',
  `q_question` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`q_id`),
  KEY `FK_v_question_to_survey` (`q_survey`),
  KEY `FK_v_question_to_question_type` (`q_type`),
  CONSTRAINT `FK_v_question_to_question_type` FOREIGN KEY (`q_type`) REFERENCES `v_question_type` (`qt_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_v_question_to_survey` FOREIGN KEY (`q_survey`) REFERENCES `v_survey` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Questions belonging to specific survey';
INSERT INTO `vote`.`v_question` VALUES  (1,1,1,'How often do you use our product?'),
 (2,1,1,'Overall, how satisfied are you with our product?'),
 (3,1,1,'Would you recommend our product to others?'),
 (4,1,3,'What recommendations would you offer for improving?'),
 (5,2,1,'Which Crocodile Rock Cafe did you visit?'),
 (6,2,3,'Please enter the date and time of your visit?'),
 (7,2,2,'Which of the following items did you order today?'),
 (8,2,1,'How old are you?'),
 (9,2,3,'Are there any other comments that you would like to make?'),
 (10,3,1,'Are you a member of Activate Swimming Club?'),
 (11,3,1,' For how long have you been a member?'),
 (12,3,1,'Would you be interested in becoming a member?'),
 (13,3,3,'If \'yes\', Please give your email address:'),
 (14,3,2,'Which services would you also like to join?');
CREATE TABLE  `vote`.`v_question_type` (
  `qt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qt_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `qt_name` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`qt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Question types.QT define how should be question answered.';
INSERT INTO `vote`.`v_question_type` VALUES  (1,1,'Radio type'),
 (2,2,'Checkbox type'),
 (3,3,'Raw answer type');
CREATE TABLE  `vote`.`v_survey` (
  `s_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_creator` int(10) unsigned DEFAULT NULL COMMENT 'Could be null - anonymous surveys.',
  `s_title` varchar(45) NOT NULL DEFAULT 'Anonymous survey',
  `s_type` int(10) unsigned DEFAULT '0',
  `s_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `s_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `s_hash_or_url` varchar(45) NOT NULL DEFAULT '/basic/url',
  PRIMARY KEY (`s_id`),
  KEY `idx_s_creator` (`s_creator`),
  CONSTRAINT `FK_v_survey_creator` FOREIGN KEY (`s_creator`) REFERENCES `v_user` (`usr_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Survey pattern table.';
INSERT INTO `vote`.`v_survey` VALUES  (1,2,'Product survey',0,'2013-12-01 15:00:00','2013-12-01 23:59:59','/basic/url'),
 (2,2,'Crocodile Rock Cafe Survey',0,'2013-12-29 12:00:00','2014-02-14 23:59:59','/basic/url'),
 (3,2,'Swimming club membership survey',0,'2013-12-01 10:00:00','2013-12-31 23:59:59','/basic/url'),
 (4,2,'Empty survey',0,'2013-12-14 11:00:00','2013-12-18 11:59:59','/basic/url');
CREATE TABLE  `vote`.`v_survey_data` (
  `sd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sd_survey` int(10) unsigned NOT NULL DEFAULT '0',
  `sd_respondent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`sd_id`),
  KEY `FK_v_survey_data_to_survey` (`sd_survey`),
  KEY `FK_v_survey_data_to_user` (`sd_respondent`),
  CONSTRAINT `FK_v_survey_data_to_survey` FOREIGN KEY (`sd_survey`) REFERENCES `v_survey` (`s_id`),
  CONSTRAINT `FK_v_survey_data_to_user` FOREIGN KEY (`sd_respondent`) REFERENCES `v_user` (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Survey data created by anyone who answers/fills the survey f';
INSERT INTO `vote`.`v_survey_data` VALUES  (1,1,3),
 (2,2,3),
 (3,3,3);
CREATE TABLE  `vote`.`v_user` (
  `usr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usr_nick` varchar(32) NOT NULL DEFAULT '' COMMENT 'required, max 32 chars',
  `usr_email` varchar(64) NOT NULL DEFAULT '' COMMENT 'required, max 32 chars',
  `usr_gender` tinyint(1) DEFAULT '0',
  `usr_year_of_birth` year(4) DEFAULT NULL COMMENT '4 digits format',
  `usr_country` varchar(45) DEFAULT NULL,
  `usr_nationality` varchar(45) DEFAULT '',
  `usr_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usr_id`,`usr_nick`,`usr_email`),
  KEY `idx_u_nick` (`usr_nick`),
  KEY `idx_u_email` (`usr_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Vote app db users';
INSERT INTO `vote`.`v_user` VALUES  (1,'Puwel','pavol.dano@gmail.com',0,1990,'Slovakia','Slovak','2013-12-03 13:50:21'),
 (2,'Liene','liene.berze@gmail.com',1,1992,'Litvia','Litvian','2013-12-04 18:34:55'),
 (3,'Julia','julia.wallner@gmx.at',1,1993,'Austria','Austrian','2013-12-01 10:15:44');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
