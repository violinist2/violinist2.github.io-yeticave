-- получить список из всех категорий;
SELECT category_name FROM categories;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, количество ставок, название категории;
SELECT items.item_name, items.price_start, items.image_path,
(SELECT count(bets.id) FROM bets WHERE bets.item_id=items.id), categories.category_name
FROM items JOIN categories ON items.category_id = categories.id
WHERE items.date_end > NOW() ORDER BY items.date_end DESC 
-- (p.s. и ЭТО - БАЗОВЫЙ интенсив?)

-- найти лот по его названию или описанию;
SELECT * FROM items WHERE item_name LIKE '%Маска%' OR description LIKE '%Маска%';

-- добавить новый лот (все данные из формы добавления);
INSERT INTO items SET date_add = NOW(), item_name = '2014 Rossignol District Snowboard', 
description = 'Модное описание сноуборда.', image_path = 'img/lot-1.jpg', 
price_start = '10999', date_end = '2017-06-08 16:40:28', bet_step = '1000', 
user_author_id = '3', category_id = '1'; 

-- обновить название лота по его идентификатору;
UPDATE items SET item_name = 'Маска Oakley Canopy розовая со стразами' WHERE id = '6';

-- добавить новую ставку для лота;
INSERT INTO bets SET id = NULL, bet_amount = '10900', user_id = '2', item_id = '5', date_betmade = NOW();

-- получить список ставок для лота по его идентификатору.
SELECT * FROM bets WHERE item_id = '1';