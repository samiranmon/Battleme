/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  root
 * Created: 9 May, 2018
 */



CREATE TABLE `script` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: active, 0: inactive',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `script_delivery` (
  `id` int(11) NOT NULL,
  `script_id` int(11) NOT NULL,
  `delivery_percentage` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `script_price` (
  `id` int(11) NOT NULL,
  `script_id` int(11) NOT NULL,
  `price` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `script_volume` (
  `id` int(11) NOT NULL,
  `script_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Constraints for table `script_delivery`
--
ALTER TABLE `script_delivery`
  ADD CONSTRAINT `script_delivery_ibfk_1` FOREIGN KEY (`script_id`) REFERENCES `script` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `script_price`
--
ALTER TABLE `script_price`
  ADD CONSTRAINT `script_price_ibfk_1` FOREIGN KEY (`script_id`) REFERENCES `script` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `script_volume`
--
ALTER TABLE `script_volume`
  ADD CONSTRAINT `script_volume_ibfk_1` FOREIGN KEY (`script_id`) REFERENCES `script` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `script`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1829;
--
-- AUTO_INCREMENT for table `script_delivery`
--
ALTER TABLE `script_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5325;
--
-- AUTO_INCREMENT for table `script_price`
--
ALTER TABLE `script_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5325;
--
-- AUTO_INCREMENT for table `script_volume`
--
ALTER TABLE `script_volume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5325;


ALTER TABLE `script`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `script_delivery`
--
ALTER TABLE `script_delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `script_id` (`script_id`);

--
-- Indexes for table `script_price`
--
ALTER TABLE `script_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `script_id` (`script_id`);

--
-- Indexes for table `script_volume`
--
ALTER TABLE `script_volume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `script_id` (`script_id`);

ALTER TABLE `script_delivery` ADD `delivery_qty` INT(11) NULL DEFAULT '0' AFTER `script_id`;