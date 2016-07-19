DELETE FROM `sports` WHERE `id` IN ('1');
DELETE FROM `sports` WHERE `id` IN ('2');

INSERT INTO sports
(
  `id`,
  `name`
)
select 
 id,
 name
 from woozard_old_db.sports;

 /* insert sports ids that was deleted but was used for previous leagues that's still active before the deletion happened   */

 INSERT INTO `sports` (`id`, `name`, `name_localized`, `created_at`, `updated_at`)
VALUES
  (40, 'Handball ', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

INSERT INTO `sports` (`id`, `name`, `name_localized`, `created_at`, `updated_at`)
VALUES
  (52, 'Lacrosse', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

INSERT INTO `sports` (`id`, `name`, `name_localized`, `created_at`, `updated_at`)
VALUES
  (58, 'Flag Football', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');


INSERT INTO `sports` (`id`, `name`, `name_localized`, `created_at`, `updated_at`)
VALUES
  (8, 'Softball', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
