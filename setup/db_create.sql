
-- Create available roles table
CREATE TABLE `availableroles` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `role_name` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Create user table
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `email` varchar(320) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Create has_role table
CREATE TABLE `hasrole` (
 `user_id` int(11) NOT NULL,
 `role_id` int(11) NOT NULL,
 PRIMARY KEY (`user_id`,`role_id`),
 KEY `role_id_FK` (`role_id`),
 CONSTRAINT `role_id_FK` FOREIGN KEY (`role_id`) REFERENCES `availableroles` (`id`),
 CONSTRAINT `user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert base roles
INSERT INTO availableroles (role_name)
VALUES 
	("USER"),
	("ADMIN");

-- Give each user user role after insert
CREATE TRIGGER `give_user_role` AFTER INSERT ON `user`
 FOR EACH ROW insert into hasrole (user_id, role_id)
select NEW.id, id from availableroles
where role_name="USER";

-- Insert admin user
INSERT INTO USER (username, email, full_name, hashed_password)
values ("ADMIN", "NO_EMAIL", "ADMIN ADMIN", "$2y$10$yWY7OR4I67D5Hd4/9QB9LORNnuWsHIokZ8gswwEdoFpSkG0mZoO5q");

-- Insert test user
INSERT INTO USER (username, email, full_name, hashed_password)
values ("TEST", "ivvaannnnnn@gmail.com", "TEST TESTOVI", "$2y$10$TVf339oPr5Ck0yzc/mOFGeDRfGeWyFtyGW2XG3KUb.8bGTHyUCYIW");

-- User with username=admin gets ADMIN role
INSERT INTO hasrole (user_id, role_id)
select user.id as user_id, availableroles.id as role_id from user
left outer join availableroles on availableroles.role_name = "ADMIN"
where user.username = "ADMIN";

-- Test select statements
SELECT * FROM USER;
SELECT * FROM HASROLE;
SELECT * FROM AVAILABLEROLES;