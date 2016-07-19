INSERT INTO leagues
(
  `id`,
  `organization_id`,
  `name`,
  `active` 
)
select 
 id,
 (
  select 
  (select id from organizations where user_id = wu.id) as id
  from woozard.users as wu
  where id IS NOT NULL 
  and  wu.email = (select email from woozard_old_db.vendor as old_db where old_db.id = old_promotion.p_id and email IS NOT NULL ) 
  COLLATE utf8_general_ci
  
) as organization_id,
name,
status as active
from woozard_old_db.promotions as old_promotion
where old_promotion.`status` = '1'
and name IS NOT NULL
and  EXISTS( select v.email  as _email from woozard_old_db.vendor  as v where v.id = old_promotion.p_id and v.status  = '0' )