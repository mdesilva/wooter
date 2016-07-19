INSERT INTO users
(
   id,
   email,
   password,
   `key`,
   phone,
   soc_id,
   verified,
   type_network,
   referral_user_id,
   first_name,
   last_name,
   `code`,
   gender,
   birthday,
   picture,
   created_at,
   user_key
)
select
 u.`id`,
 email,
 u.pswd as password,
 salt as 'key',
 phone as phone,
 soc_id,
 valid as verified,
 type_network,
 referral_user_id,
 first_name,
 last_name,
 `code`,
 gender,
 birthday,
 photo_path as picture,
 cdate as created_at,
 user_key
from woozard_old_db.user as u 
inner join woozard_old_db.user_info as ui on u.id = ui.user_id;