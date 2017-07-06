---- ****** Date : 12Feb 2016 ****---
--
-- Database: `battle`
--

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
`id` int(12) NOT NULL,
  `membership` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `membership`, `description`, `created_on`, `updated_on`) VALUES
(1, 'Free membership', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2016-02-10 14:28:08', '0000-00-00 00:00:00'),
(2, 'Premium Membership', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2016-02-10 14:28:08', '0000-00-00 00:00:00'),
(3, 'Fan Membership', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2016-02-10 15:22:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE IF NOT EXISTS `user_memberships` (
`id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `memberships_id` int(12) NOT NULL,
  `status` int(12) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;




--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_memberships`
--
ALTER TABLE `user_memberships`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `memberships_id` (`memberships_id`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
MODIFY `id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_memberships`
--
ALTER TABLE `user_memberships`
MODIFY `id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;



--
-- Constraints for table `user_memberships`
--
ALTER TABLE `user_memberships`
ADD CONSTRAINT `user_memberships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `user_memberships_ibfk_2` FOREIGN KEY (`memberships_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;




---- ****** Date : 15Feb 2016 ****---

ALTER TABLE `memberships` ADD `membership_days` INT(12) NOT NULL AFTER `description`;

ALTER TABLE `memberships` ADD `membership_amount` FLOAT(11) NOT NULL AFTER `membership_days`;



------********** Date 16Feb 2016*******--------


CREATE TABLE IF NOT EXISTS `battle_me` (
`battle_id` int(12) NOT NULL,
  `subject` varchar(400) NOT NULL,
  `description` text NOT NULL,
  `battle_date` timestamp NOT NULL,
  `subject_id` int(12) NOT NULL,
  `object_id` int(12) NOT NULL,
  `battle_status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '1=>''accept'' 2=>''reject'', 0=>''challenge''',
  `created_on` timestamp NOT NULL DEFAULT  CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `battle_me`
--
ALTER TABLE `battle_me`
 ADD PRIMARY KEY (`battle_id`), ADD KEY `subject_id` (`subject_id`), ADD KEY `object_id` (`object_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `battle_me`
--
ALTER TABLE `battle_me`
MODIFY `battle_id` int(12) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `battle_me`
--
ALTER TABLE `battle_me`
ADD CONSTRAINT `battle_me_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `battle_me_ibfk_2` FOREIGN KEY (`object_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
