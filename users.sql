
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


