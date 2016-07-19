INSERT INTO organizations
(

 `user_id`,
 `name`,
 `description`,
 `image`,
 `phone`,
 `email`,
 `status`,
 `entry`,
 `modef`,
 `verified`,
 `facebook`,
 `twitter`,
 `instagram`,
 `pinterest`,
 `google`

) 
select

  (  select id 
  from woozard.users as wu 
  where id IS NOT NULL and  wu.email = (select email from woozard_old_db.vendor as old_db where old_db.id = c.id and email IS NOT NULL ) COLLATE utf8_general_ci
  ) as user_id ,
 `name` ,
 `description` ,
 `image` ,
 `phone`,
 `email` ,
 `status`,
 `entry` ,
 `modef`,
 `verified`,
 `facebook`,
 `twitter`,
 `instagram`,
 `pinterest`,
 `google`
from woozard_old_db.company as c  where  
EXISTS 
(
  SELECT v.id
  from woozard_old_db.vendor as v 
  inner join woozard_old_db.promotions as p on p.p_id = v.id  
  where p.status = "1"  and v.id = c.id and  name IS NOT NULL 
)