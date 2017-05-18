CREATE TABLE `symfony`.`to_do` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `memo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `r_datetime` datetime DEFAULT NULL,
  `u_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;