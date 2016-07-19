INSERT INTO users
(
  email,
  password,
  `key`,
  created_at,
  preselected_role
)
select 
 v.email,
 pswd as password,
 salt as 'key',
 cdate as created_at,
 '3' as preselected_role
from woozard_old_db.vendor as v 
inner join woozard_old_db.promotions as p on p.p_id = v.id  
where p.status = "1" 
and  name IS NOT NULL 
and  NOT EXISTS( select u.email  as _email from users  as u   where   u.email = v.email COLLATE utf8_general_ci)   
group by email