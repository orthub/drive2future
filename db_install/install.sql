DROP SCHEMA IF EXISTS `drive2future`;
CREATE SCHEMA IF NOT EXISTS `drive2future` DEFAULT CHARACTER SET utf8mb4;
USE `drive2future`;
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
  time_zone = "+00:00";
  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;
--
  -- Datenbank: `drive2future`
  --
  -- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `appointments`
  --
  CREATE TABLE `appointments` (
    `id_appointment` int(11) NOT NULL,
    `date` date NOT NULL,
    `begin_time` time NOT NULL,
    `end_time` time NOT NULL,
    `description` TEXT NOT NULL,
    `appointment_types_id_a_type` int(11) NOT NULL,
    `rooms_id_room` int(11) NOT NULL,
    `class_id_class` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `appointments`
  --
  -- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `appointment_types`
  --
  CREATE TABLE `appointment_types` (
    `id_a_type` int(11) NOT NULL,
    `description` varchar(45) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `appointment_types`
  --
INSERT INTO
  `appointment_types` (`id_a_type`, `description`)
VALUES
  (1, 'Vortrag'),
  (2, 'Übung'),
  (3, 'Fahrstunde');
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `class`
  --
  CREATE TABLE `class` (
    `id_class` int(11) NOT NULL,
    `class_label` varchar(45) NOT NULL,
    `status` varchar(45) NOT NULL,
    `begin_date` date NOT NULL,
    `end_date` date NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `class`
  --
INSERT INTO
  `class` (
    `id_class`,
    `class_label`,
    `status`,
    `begin_date`,
    `end_date`
  )
VALUES
  (
    1,
    'A - Sommer_22',
    'aktiv',
    '2022-06-30',
    '2022-07-28'
  );
INSERT INTO
  `class` (
    `id_class`,
    `class_label`,
    `status`,
    `begin_date`,
    `end_date`
  )
VALUES
  (
    2,
    'B - Sommer_22',
    'aktiv',
    '2022-08-01',
    '2022-08-30'
  );
INSERT INTO
  `class` (
    `id_class`,
    `class_label`,
    `status`,
    `begin_date`,
    `end_date`
  )
VALUES
  (
    3,
    'A - Herbst_22',
    'aktiv',
    '2022-09-01',
    '2022-09-30'
  );
INSERT INTO
  `class` (
    `id_class`,
    `class_label`,
    `status`,
    `begin_date`,
    `end_date`
  )
VALUES
  (
    4,
    'F - Herbst_22',
    'aktiv',
    '2022-10-01',
    '2022-10-30'
  );
INSERT INTO
  `class` (
    `id_class`,
    `class_label`,
    `status`,
    `begin_date`,
    `end_date`
  )
VALUES
  (
    5,
    'B - Herbst_22',
    'aktiv',
    '2022-11-01',
    '2022-11-30'
  );
INSERT INTO
  `class` (
    `id_class`,
    `class_label`,
    `status`,
    `begin_date`,
    `end_date`
  )
VALUES
  (
    6,
    'B - Winter_23',
    'aktiv',
    '2023-01-08',
    '2023-02-10'
  );
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `class_has_users`
  --
  CREATE TABLE `class_has_users` (
    `class_id_class` int(11) NOT NULL,
    `users_id_user` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `class_has_users`
  --
INSERT INTO
  `class_has_users` (`class_id_class`, `users_id_user`)
VALUES
  (1, 2);
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `documents`
  --
  CREATE TABLE `documents` (
    `id_documents` int(11) NOT NULL,
    `path` varchar(128) NOT NULL,
    `date` datetime NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `license_type`
  --
  CREATE TABLE `license_type` (
    `id_license_type` int(11) NOT NULL,
    `description` varchar(45) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `license_type`
  --
INSERT INTO
  `license_type` (`id_license_type`, `description`)
VALUES
  (1, 'Typ A'),
  (2, 'Typ B'),
  (3, 'Typ F');
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `roles`
  --
  CREATE TABLE `roles` (
    `id_role` int(11) NOT NULL,
    `r_type` varchar(45) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `roles`
  --
INSERT INTO
  `roles` (`id_role`, `r_type`)
VALUES
  (1, 'ADMIN'),
  (2, 'STUDENT'),
  (3, 'EMPLOYEE');
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `rooms`
  --
  CREATE TABLE `rooms` (
    `id_room` int(11) NOT NULL,
    `room_name` varchar(45) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `rooms`
  --
INSERT INTO
  `rooms` (`id_room`, `room_name`)
VALUES
  (1, 'Warteraum'),
  (2, 'Schulungsraum'),
  (3, 'Übungsraum');
-- ------------------------------------------------------
  -- Daten für Tabelle `appointments`
INSERT INTO
  `appointments` (
    `id_appointment`,
    `date`,
    `begin_time`,
    `end_time`,
    `description`,
    `appointment_types_id_a_type`,
    `rooms_id_room`,
    `class_id_class`
  )
VALUES
  (
    1,
    '2022-05-12',
    '08:00:00',
    '12:00:00',
    'Vortrag Einführung in die STVO',
    1,
    2,
    1
  ),
  (
    2,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  ),
  (
    3,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Übung ',
    2,
    1,
    1
  ),
  (
    4,
    '2022-05-12',
    '13:00:00',
    '14:00:00',
    'Fahrstunde',
    3,
    1,
    1
  ),
  (
    5,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  ),
  (
    6,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  ),
  (
    7,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  ),
  (
    8,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  ),
  (
    9,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  ),
  (
    10,
    '2022-06-18',
    '08:00:00',
    '12:00:00',
    'Vortrag Gefahren im Verkehr',
    1,
    2,
    1
  );
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `users`
  --
  CREATE TABLE `users` (
    `id_user` int(11) NOT NULL,
    `first_name` varchar(45) NOT NULL,
    `last_name` varchar(45) NOT NULL,
    `email` varchar(45) NOT NULL,
    `password` varchar(255) NOT NULL,
    `status` varchar(45) NOT NULL,
    `roles_id_role` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `users`
  --
INSERT INTO
  `users` (
    `id_user`,
    `first_name`,
    `last_name`,
    `email`,
    `password`,
    `status`,
    `roles_id_role`
  )
VALUES
  (
    1,
    'John',
    'Doe',
    'admin@drive2future.at',
    '$2y$10$Yyq//sOQUESbtcRDeq8UR.sWYxE16yYo6t/Ju2uz7yuGBc4wMjQL6',
    'aktiv',
    1
  ),
  (
    2,
    'Jane',
    'Doe',
    'employee@drive2future.at',
    '$2y$10$PrnMtBS.x3y9Ev1iuIoqjeInXFAYybeGcv4P1HUF7kE4bB0SHRVE2',
    'aktiv',
    3
  ),
  (
    3,
    'Sabine',
    'Müller',
    's.mueller@drive2future.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    3
  ),
  (
    4,
    'Markus',
    'Sauber',
    'm.sauber@drive2future.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    3
  ),
  (
    5,
    'Maria',
    'Oberhauser',
    'm.oberhauser@drive2future.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    3
  ),
  (
    6,
    'Raffaela',
    'Hochreiter',
    'r.hochreiter@drive2future.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    3
  ),
  (
    7,
    'Johannes',
    'Hauser',
    'j.hauser@email.com',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    8,
    'Kurt',
    'Wesser',
    'k.wesser@agmail.com',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    9,
    'Lara',
    'Hofmaier',
    'l.hofmaier@vhotmail.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    10,
    'Richard',
    'Schwarzstein',
    'r.schwarzstein@bmail.de',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    11,
    'Tobias',
    'Kastner',
    't.kastner@ilive.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    12,
    'Nicole',
    'Neumann',
    'n.neumann@atmail.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    13,
    'Thomas',
    'Bergmann',
    't.bergmann@bgmail.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    14,
    'Tanja',
    'Schreiner',
    't.schreiner@ilive.de',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    15,
    'Christian',
    'Engel',
    'c.engel@atmail.at',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  ),
  (
    16,
    'Franziska',
    'Abend',
    'f.abend@omail.com',
    '$2y$10$p08dDvVzTDb15jlV1VxseOocDZjiVHlBys3bHUDFnbcfioK3/a.6m',
    'aktiv',
    2
  );
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `users_has_appointments`
  --
  CREATE TABLE `users_has_appointments` (
    `users_id_user` int(11) NOT NULL,
    `appointments_id_appointment` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
  --
  -- Tabellenstruktur für Tabelle `users_has_license_type`
  --
  CREATE TABLE `users_has_license_type` (
    `users_id_user` int(11) NOT NULL,
    `license_type_id_license_type` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Daten für Tabelle `users_has_license_type`
  --
INSERT INTO
  `users_has_license_type` (`users_id_user`, `license_type_id_license_type`)
VALUES
  (2, 1);
--
  -- Indizes der exportierten Tabellen
  --
  --
  -- Indizes für die Tabelle `appointments`
  --
ALTER TABLE
  `appointments`
ADD
  PRIMARY KEY (`id_appointment`, `class_id_class`),
ADD
  KEY `fk_appointments_appointment_types1_idx` (`appointment_types_id_a_type`),
ADD
  KEY `fk_appointments_rooms1_idx` (`rooms_id_room`),
ADD
  KEY `fk_appointments_class1_idx` (`class_id_class`);
--
  -- Indizes für die Tabelle `appointment_types`
  --
ALTER TABLE
  `appointment_types`
ADD
  PRIMARY KEY (`id_a_type`);
--
  -- Indizes für die Tabelle `class`
  --
ALTER TABLE
  `class`
ADD
  PRIMARY KEY (`id_class`);
-- Indizes für die Tabelle `class_has_users`
  --
ALTER TABLE
  `class_has_users`
ADD
  PRIMARY KEY (`class_id_class`, `users_id_user`),
ADD
  KEY `fk_class_has_users_users1_idx` (`users_id_user`),
ADD
  KEY `fk_class_has_users_class1_idx` (`class_id_class`);
--
  -- Indizes für die Tabelle `documents`
  --
ALTER TABLE
  `documents`
ADD
  PRIMARY KEY (`id_documents`);
--
  -- Indizes für die Tabelle `license_type`
  --
ALTER TABLE
  `license_type`
ADD
  PRIMARY KEY (`id_license_type`);
--
  -- Indizes für die Tabelle `roles`
  --
ALTER TABLE
  `roles`
ADD
  PRIMARY KEY (`id_role`);
--
  -- Indizes für die Tabelle `rooms`
  --
ALTER TABLE
  `rooms`
ADD
  PRIMARY KEY (`id_room`);
--
  -- Indizes für die Tabelle `users`
  --
ALTER TABLE
  `users`
ADD
  PRIMARY KEY (`id_user`),
ADD
  UNIQUE KEY `email_UNIQUE` (`email`),
ADD
  KEY `fk_users_roles_idx` (`roles_id_role`);
--
  -- Indizes für die Tabelle `users_has_appointments`
  --
ALTER TABLE
  `users_has_appointments`
ADD
  PRIMARY KEY (`users_id_user`, `appointments_id_appointment`),
ADD
  KEY `fk_users_has_appointments_appointments1_idx` (`appointments_id_appointment`),
ADD
  KEY `fk_users_has_appointments_users1_idx` (`users_id_user`);
--
  -- Indizes für die Tabelle `users_has_license_type`
  --
ALTER TABLE
  `users_has_license_type`
ADD
  PRIMARY KEY (`users_id_user`, `license_type_id_license_type`),
ADD
  KEY `fk_users_has_license_type_license_type1_idx` (`license_type_id_license_type`),
ADD
  KEY `fk_users_has_license_type_users1_idx` (`users_id_user`);
--
  -- AUTO_INCREMENT für exportierte Tabellen
  --
  --
  -- AUTO_INCREMENT für Tabelle `appointments`
  --
ALTER TABLE
  `appointments`
MODIFY
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
  -- AUTO_INCREMENT für Tabelle `appointment_types`
  --
ALTER TABLE
  `appointment_types`
MODIFY
  `id_a_type` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
  -- AUTO_INCREMENT für Tabelle `class`
  --
ALTER TABLE
  `class`
MODIFY
  `id_class` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
  -- AUTO_INCREMENT für Tabelle `documents`
  --
ALTER TABLE
  `documents`
MODIFY
  `id_documents` int(11) NOT NULL AUTO_INCREMENT;
--
  -- AUTO_INCREMENT für Tabelle `license_type`
  --
ALTER TABLE
  `license_type`
MODIFY
  `id_license_type` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;
--
  -- AUTO_INCREMENT für Tabelle `roles`
  --
ALTER TABLE
  `roles`
MODIFY
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;
--
  -- AUTO_INCREMENT für Tabelle `rooms`
  --
ALTER TABLE
  `rooms`
MODIFY
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
  -- AUTO_INCREMENT für Tabelle `users`
  --
ALTER TABLE
  `users`
MODIFY
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
  -- Constraints der exportierten Tabellen
  --
  --
  -- Constraints der Tabelle `appointments`
  --
ALTER TABLE
  `appointments`
ADD
  CONSTRAINT `fk_appointments_appointment_types1` FOREIGN KEY (`appointment_types_id_a_type`) REFERENCES `appointment_types` (`id_a_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_appointments_class1` FOREIGN KEY (`class_id_class`) REFERENCES `class` (`id_class`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_appointments_rooms1` FOREIGN KEY (`rooms_id_room`) REFERENCES `rooms` (`id_room`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
ALTER TABLE
  `class_has_users`
ADD
  CONSTRAINT `fk_class_has_users_class1` FOREIGN KEY (`class_id_class`) REFERENCES `class` (`id_class`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_class_has_users_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Constraints der Tabelle `users`
  --
ALTER TABLE
  `users`
ADD
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`roles_id_role`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Constraints der Tabelle `users_has_appointments`
  --
ALTER TABLE
  `users_has_appointments`
ADD
  CONSTRAINT `fk_users_has_appointments_appointments1` FOREIGN KEY (`appointments_id_appointment`) REFERENCES `appointments` (`id_appointment`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_users_has_appointments_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Constraints der Tabelle `users_has_license_type`
  --
ALTER TABLE
  `users_has_license_type`
ADD
  CONSTRAINT `fk_users_has_license_type_license_type1` FOREIGN KEY (`license_type_id_license_type`) REFERENCES `license_type` (`id_license_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_users_has_license_type_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;