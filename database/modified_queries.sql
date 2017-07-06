/* 18th Feb 2016 */
CREATE TABLE IF NOT EXISTS `battle_request` (
  `battle_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_user_id` int(11) NOT NULL,
  `battle_name` varchar(125) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '0 - pending , 1 accept , 2 reject',
  PRIMARY KEY (`battle_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/* 19 Feb 2016 */

ALTER TABLE `notifications` ADD `notification_type` VARCHAR( 75 ) NULL AFTER `id` ;

ALTER TABLE `notifications` ADD `data_id` INT( 11 ) NULL COMMENT 'for battle request to save the request Id' AFTER `notification_type` ;

/* 22 nd FEB */
ALTER TABLE `post` ADD `data_id` INT( 11 ) NULL COMMENT 'for clickable post ' AFTER `object_id` ;

/* 23rd Feb */
CREATE TABLE IF NOT EXISTS `battle_votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `battle_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/* 24th Feb */
ALTER TABLE `battle_votes` ADD `social_media_type` VARCHAR( 125 ) NOT NULL COMMENT 'by which social media user has shared battle page and placed vote ' AFTER `artist_id` ;




/* 25 th Feb */

CREATE TABLE IF NOT EXISTS `battle_media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `battle_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `title` varchar(125) DEFAULT NULL,
  `media` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;




/* 29th Feb */
ALTER TABLE `user` ADD `win_cnt` INT( 11 ) NOT NULL DEFAULT '0' AFTER `aboutme` ,
ADD `lose_cnt` INT( 11 ) NOT NULL DEFAULT '0' AFTER `win_cnt` ;


ALTER TABLE `battle_request` ADD `winner` INT( 11 ) NOT NULL COMMENT 'id of winner artists' AFTER `end_date` ;

CREATE TABLE IF NOT EXISTS `song_library` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media` varchar(255) NOT NULL,
  `title` varchar(125) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`song_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `battle_media` ADD `fk_song_id` INT( 11 ) NOT NULL AFTER `artist_id` ;

ALTER TABLE `likes` ADD `post_type` VARCHAR( 25 ) NULL COMMENT 'this will save what user has liked , weather post , song or something else' AFTER `post_id` ;
