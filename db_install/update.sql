USE `drive2future`;
ALTER TABLE
  `class_has_users`
ADD
  CONSTRAINT `fk_class_has_users_class1` FOREIGN KEY (`class_id_class`) REFERENCES `class` (`id_class`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_class_has_users_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE
  `users_has_appointments`
ADD
  CONSTRAINT `fk_users_has_appointments_appointments1` FOREIGN KEY (`appointments_id_appointment`) REFERENCES `appointments` (`id_appointment`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_users_has_appointments_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;