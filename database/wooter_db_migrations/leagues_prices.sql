/* update all promotion prices to not use -jersey anymore */
UPDATE woozard_old_db.promotion_prices
SET type='free', includesJersey='1'
WHERE type='free-jersey';


UPDATE woozard_old_db.promotion_prices
SET type='new', includesJersey='1'
WHERE type='new-jersey';


UPDATE woozard_old_db.promotion_prices
SET type='returning', includesJersey='1'
WHERE type='returning-jersey';



INSERT INTO league_prices
(
  `id`,
  `league_id`,
  `currency_id`,
  `name`,
  `types`,
  `price`,
  `includes_jersey`,
  `n_games`
)
select 
  p.`id` ,
  `p_id` ,
  '1' as currency_id,
  p.`name`,
  p.`type`,
  p.`new`,
  p.`includesJersey`,
  p.`n_games`
from leagues  as l 
inner join woozard_old_db.promotion_prices as p on p.p_id = l.id  
where type in ("free","new","returning")


