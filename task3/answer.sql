SELECT name, COUNT(*) FROM users
LEFT JOIN phone_numbers pn ON users.id = pn.user_id
WHERE gender = 2
AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), FROM_UNIXTIME(users.birth_date))), '%Y') >= 18
AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), FROM_UNIXTIME(users.birth_date))), '%Y') < 22
GROUP BY name