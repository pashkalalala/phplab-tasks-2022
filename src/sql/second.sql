SELECT DISTINCT name
FROM cinema;

SELECT name, country, genre
FROM movie
WHERE country LIKE 'СШ%' AND year = '2021'
ORDER BY name;

SELECT session.date, session.free_places, movie.name, movie.genre
FROM movie
JOIN session ON session.movie_id = movie.id 
WHERE date = '2021-02-20'; 

SELECT movie.name, session.free_places, hall.roominess, hall.technology
FROM session 
LEFT JOIN hall ON session.hall_id = hall.id
LEFT JOIN movie ON session.movie_id = movie.id
ORDER BY movie.name
LIMIT 3;

SELECT name, COUNT(*) AS Count
FROM hall
GROUP BY name
HAVING COUNT(*) = 5;

SELECT name
FROM movie
UNION 
SELECT name 
FROM cinema
ORDER BY name DESC;

SELECT  name, roominess, 
        (SELECT name FROM cinema 
        WHERE cinema.id = hall.cinema_id) AS cinemas
FROM hall
WHERE roominess < 100
ORDER BY roominess DESC;