-- get session variable
SELECT
    `organisation_has_user`.*
FROM
    `organisation_has_user`
INNER JOIN `user` ON `user`.`id` = `organisation_has_user`.`user_id`
INNER JOIN `organisation` ON `organisation`.`id` = `organisation_has_user`.`organisation_id`
WHERE
    `user`.`id` = 11 
    AND `user`.`status_id` = 1 
    AND `organisation_has_user`.`status_id` = 1 
    AND `organisation`.`status_id` = 1;


-- get permission 
SELECT
    `permission`.`id`,
    `permission`.`name`,
    `permission`.`description`
FROM
    `permission`
INNER JOIN `role_has_permission` ON `role_has_permission`.`permission_id` = `permission`.`id`
INNER JOIN `role` ON `role`.`id` = `role_has_permission`.`role_id`
INNER JOIN `user_has_role` ON `user_has_role`.`role_id` = `role`.`id`
INNER JOIN `organisation_has_user` ON `organisation_has_user`.`id` = `user_has_role`.`organisation_has_user_id`
INNER JOIN `organisation` ON `organisation`.`id` = `organisation_has_user`.`organisation_id`
WHERE
    `organisation_has_user`.`id` = 1 AND `organisation_has_user`.`status_id` = 1 AND `organisation`.`status_id` = 1
    
-- get role 
SELECT
    `role`.`id`,
    `role`.`name`
FROM
    `role`
INNER JOIN `user_has_role` ON `user_has_role`.`role_id` = `role`.`id`
INNER JOIN `organisation_has_user` ON `organisation_has_user`.`id` = `user_has_role`.`organisation_has_user_id`
INNER JOIN 	`organisation` ON `organisation`.`id` = `organisation_has_user`.`organisation_id`
WHERE
    `organisation_has_user`.`id` = 1 AND `organisation_has_user`.`status_id` = 1 AND `organisation`.`status_id` = 1