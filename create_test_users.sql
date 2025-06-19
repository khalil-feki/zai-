-- Create 20 test users with sequential passwords starting from 100000
-- Avoiding khalilfeki8@gmail.com which is already used

INSERT INTO `h8pd_user` (`entity`, `login`, `pass_crypted`, `lastname`, `firstname`, `email`, `admin`, `fk_soc`, `datec`, `tms`) VALUES
(1, 'khalil1', '$2y$10$abcdefghijklmnopqrstuv.ABCDEFGHIJKLMNOPQRSTUVWXYZ123456', 'Feki', 'Khalil', 'khalilfeki1@gmail.com', 0, NULL, NOW(), NOW()),
(2, 'khalil2', '$2y$10$bcdefghijklmnopqrstuva.BCDEFGHIJKLMNOPQRSTUVWXYZ123457', 'Feki', 'Khalil2', 'khalilfeki2@gmail.com', 0, NULL, NOW(), NOW()),
(3, 'khalil3', '$2y$10$cdefghijklmnopqrstuvab.CDEFGHIJKLMNOPQRSTUVWXYZ123458', 'Feki', 'Khalil3', 'khalilfeki3@gmail.com', 0, NULL, NOW(), NOW()),
(4, 'khalil4', '$2y$10$defghijklmnopqrstuvabc.DEFGHIJKLMNOPQRSTUVWXYZ123459', 'Feki', 'Khalil4', 'khalilfeki4@gmail.com', 0, NULL, NOW(), NOW()),
(5, 'khalil5', '$2y$10$efghijklmnopqrstuvabcd.EFGHIJKLMNOPQRSTUVWXYZ123460', 'Feki', 'Khalil5', 'khalilfeki5@gmail.com', 0, NULL, NOW(), NOW()),
(6, 'khalil6', '$2y$10$fghijklmnopqrstuvabcde.FGHIJKLMNOPQRSTUVWXYZ123461', 'Feki', 'Khalil6', 'khalilfeki6@gmail.com', 0, NULL, NOW(), NOW()),
(7, 'khalil7', '$2y$10$ghijklmnopqrstuvabcdef.GHIJKLMNOPQRSTUVWXYZ123462', 'Feki', 'Khalil7', 'khalilfeki7@gmail.com', 0, NULL, NOW(), NOW()),
(8, 'khalil9', '$2y$10$hijklmnopqrstuvabcdefg.HIJKLMNOPQRSTUVWXYZ123463', 'Feki', 'Khalil8', 'khalilfeki9@gmail.com', 0, NULL, NOW(), NOW()),
(9, 'khalil10', '$2y$10$ijklmnopqrstuvabcdefgh.IJKLMNOPQRSTUVWXYZ123464', 'Feki', 'Khalil9', 'khalilfeki10@gmail.com', 0, NULL, NOW(), NOW()),
(10, 'khalil11', '$2y$10$jklmnopqrstuvabcdefghi.JKLMNOPQRSTUVWXYZ123465', 'Feki', 'Khalil10', 'khalilfeki11@gmail.com', 0, NULL, NOW(), NOW()),
(11, 'khalil12', '$2y$10$klmnopqrstuvabcdefghij.KLMNOPQRSTUVWXYZ123466', 'Feki', 'Khalil11', 'khalilfeki12@gmail.com', 0, NULL, NOW(), NOW()),
(12, 'khalil13', '$2y$10$lmnopqrstuvabcdefghijk.LMNOPQRSTUVWXYZ123467', 'Feki', 'Khalil12', 'khalilfeki13@gmail.com', 0, NULL, NOW(), NOW()),
(13, 'khalil14', '$2y$10$mnopqrstuvabcdefghijkl.MNOPQRSTUVWXYZ123468', 'Feki', 'Khalil13', 'khalilfeki14@gmail.com', 0, NULL, NOW(), NOW()),
(14, 'khalil15', '$2y$10$nopqrstuvabcdefghijklm.NOPQRSTUVWXYZ123469', 'Feki', 'Khalil14', 'khalilfeki15@gmail.com', 0, NULL, NOW(), NOW()),
(15, 'khalil16', '$2y$10$opqrstuvabcdefghijklmn.OPQRSTUVWXYZ123470', 'Feki', 'Khalil15', 'khalilfeki16@gmail.com', 0, NULL, NOW(), NOW()),
(16, 'khalil17', '$2y$10$pqrstuvabcdefghijklmno.PQRSTUVWXYZ123471', 'Feki', 'Khalil16', 'khalilfeki17@gmail.com', 0, NULL, NOW(), NOW()),
(17, 'khalil18', '$2y$10$qrstuvabcdefghijklmnop.QRSTUVWXYZ123472', 'Feki', 'Khalil17', 'khalilfeki18@gmail.com', 0, NULL, NOW(), NOW()),
(18, 'khalil19', '$2y$10$rstuvabcdefghijklmnopq.RSTUVWXYZ123473', 'Feki', 'Khalil18', 'khalilfeki19@gmail.com', 0, NULL, NOW(), NOW()),
(19, 'khalil20', '$2y$10$stuvabcdefghijklmnopqr.STUVWXYZ123474', 'Feki', 'Khalil19', 'khalilfeki20@gmail.com', 0, NULL, NOW(), NOW()),
(20, 'khalil21', '$2y$10$tuvabcdefghijklmnopqrs.TUVWXYZ123475', 'Feki', 'Khalil20', 'khalilfeki21@gmail.com', 0, NULL, NOW(), NOW());

-- Password mapping (each hash represents the corresponding sequential password):
-- khalil1: password = 100000
-- khalil2: password = 100001
-- khalil3: password = 100002
-- khalil4: password = 100003
-- khalil5: password = 100004
-- khalil6: password = 100005
-- khalil7: password = 100006
-- khalil9: password = 100007 (skipped khalil8 as requested)
-- khalil10: password = 100008
-- khalil11: password = 100009
-- khalil12: password = 100010
-- khalil13: password = 100011
-- khalil14: password = 100012
-- khalil15: password = 100013
-- khalil16: password = 100014
-- khalil17: password = 100015
-- khalil18: password = 100016
-- khalil19: password = 100017
-- khalil20: password = 100018
-- khalil21: password = 100019

-- Note: The password hashes above are placeholder hashes for demonstration
-- In a real environment, you would generate proper bcrypt hashes using:
-- password_hash('100000', PASSWORD_DEFAULT) for each sequential password
-- All users have unique login names and email addresses
-- Skipped khalilfeki8@gmail.com as it was already used