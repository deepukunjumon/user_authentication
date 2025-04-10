-- Select the database
USE kingslabs;

-- Create Users Table

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert Sample Data into Users Table

INSERT INTO `users` (`username`, `email`, `password_hash`) VALUES
('Test User', 'testuser@test.com', '$2y$10$N.OR6/GNYnxTbvJ1M32za.KA1zxwKFMwomWc9JuZLLHt1QuSrmCQO'),
('Deepu Kunjumon', 'deepu@gmail.com', '$2y$10$tdmSHIquiSWpZlH8ZXM/Ee8tR5h8oniSiIJzlBG7iLjBukbnGO54q');
