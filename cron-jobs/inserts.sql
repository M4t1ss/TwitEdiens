INSERT INTO baumuin_twitediens.tweets (id, text, screen_name, created_at, geo, emo)
	SELECT id, text, screen_name, created_at, geo, emo FROM baumuin_food.tweets
	WHERE DATE(tweets.created_at) = DATE(NOW() - INTERVAL 1 DAY);
INSERT INTO baumuin_twitediens.words (vards, nominativs, tvits, irediens, grupa, eng, datums)
	SELECT  vards, nominativs, tvits, irediens, grupa, eng, datums FROM baumuin_food.words
	WHERE DATE(words.datums) = DATE(NOW() - INTERVAL 1 DAY);
INSERT INTO baumuin_twitediens.mentions (tweet_id,screen_name,mention,date)
	SELECT tweet_id,screen_name,mention,date FROM baumuin_food.mentions
	WHERE DATE(mentions.date) = DATE(NOW() - INTERVAL 1 DAY);
INSERT INTO baumuin_twitediens.media (tweet_id, media_url, expanded_url, date)
	SELECT tweet_id, media_url, expanded_url, date FROM baumuin_food.media
	WHERE DATE(media.date) = DATE(NOW() - INTERVAL 1 DAY);
DELETE FROM baumuin_twitediens.tweets
WHERE created_at < CURDATE( ) - INTERVAL 3 MONTH;
DELETE FROM baumuin_twitediens.words
WHERE datums < CURDATE( ) - INTERVAL 3 MONTH;
DELETE FROM baumuin_twitediens.vardiDiena
WHERE datums < CURDATE( ) - INTERVAL 3 MONTH;
DELETE FROM baumuin_twitediens.mentions
WHERE date < CURDATE( ) - INTERVAL 3 MONTH;
DELETE FROM baumuin_twitediens.media
WHERE date < CURDATE( ) - INTERVAL 3 MONTH;
