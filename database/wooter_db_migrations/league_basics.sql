INSERT INTO league_basics
(
  `league_id`,
  `sport_id`,
  `image_id`,
  `min_age`,
  `max_age`
)
select 
wl.id as league_id,
coalesce( old_promotion.activity,6) as sport_id,
'1' as image_id,
from_age as min_age ,
to_age as max_Age 
from woozard_old_db.promotions as old_promotion
inner join woozard.leagues as wl on wl.id = old_promotion.id
where old_promotion.`status` = '1'
and old_promotion.name IS NOT NULL
and  EXISTS( select v.email  as _email from woozard_old_db.vendor  as v where v.id = old_promotion.p_id and v.status  = '0' )