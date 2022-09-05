CREATE DATABASE cinema_db;
USE cinema_db;

CREATE TABLE cinema.cinema (
id INT NOT NULL AUTO_INCREMENT ,
name VARCHAR(30) NOT NULL ,
city VARCHAR(30) NOT NULL ,
address VARCHAR(30) NOT NULL ,
phone VARCHAR(30) NOT NULL ,
PRIMARY KEY (id)) ENGINE = InnoDB;

INSERT INTO cinema 
(name, city, address, phone) VALUES
('Планета Кіно Форум', 'Львів', 'Під Дубом, 7Б', '093 200 20 20'),
('Планета Кіно Кінг Крос', 'Львів', 'Стрийська, 30', '093 300 30 30'),
('Планета Кіно Блокбастер', 'Київ', 'Степана Бандери, 34В', '093 400 40 40'),
('Планета Кіно Рівер Мал', 'Київ', 'Дніпровська набережна, 12', '093 500 50 50'),
('Планета Кіно Котовського', 'Одеса', 'Давида Ойстраха, 32', '093 600 60 60')

CREATE TABLE cinema.hall (
id INT NOT NULL AUTO_INCREMENT ,
name VARCHAR(30) NOT NULL ,
roominess VARCHAR(30) NOT NULL ,
technology VARCHAR(30) NOT NULL ,
cinema_id INT NOT NULL ,
PRIMARY KEY (id),
INDEX (cinema_id)) ENGINE = InnoDB;

ALTER TABLE hall 
ADD FOREIGN KEY (cinema_id) 
REFERENCES cinema(id) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO hall 
(name, roominess, technology, cinema_id) VALUES 
('Великий зал', '180', '3D', '1'), 
('Малий зал', '80', '2D', '1'), 
('Малий зал', '80', '3D', '2'), 
('Великий зал', '200', '3D', '2'), 
('Великий зал', '180', '3D', '3'), 
('Малий зал', '78', '2D', '3'), 
('Малий зал', '82', '2D', '4'), 
('Великий зал', '186', '3D', '4'), 
('Великий зал', '180', '3D', '5'), 
('Малий зал', '80', '2D', '5')

CREATE TABLE cinema.session (
id INT NOT NULL AUTO_INCREMENT ,
date DATE NOT NULL ,
time VARCHAR(30) NOT NULL ,
hall_id INT NOT NULL ,
movie_id INT NOT NULL ,
free_places VARCHAR(30) NOT NULL ,
PRIMARY KEY (id),
INDEX (hall_id),
INDEX (movie_id)) ENGINE = InnoDB;

ALTER TABLE session
ADD FOREIGN KEY (hall_id) 
REFERENCES hall(id) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO session 
(id, date, time, hall_id, movie_id, free_places) VALUES 
('2021-02-20', '14:00', '1', '1', '10'), 
('2021-02-21', '16:00', '2', '6', '23'), 
('2021-02-20', '16:00', '3', '5', '14'), 
('2021-02-21', '19:40', '4', '3', '36'), 
('2021-02-21', '17:10', '5', '4', '40'), 
('2021-02-20', '12:10', '6', '6', '14'), 
('2021-02-22', '19:00', '7', '2', '16'), 
('2021-02-20', '16:45', '8', '3', '36'), 
('2021-02-20', '12:45', '9', '5', '38'), 
('2021-02-21', '16:00', '10', '6', '15')

CREATE TABLE cinema.movie (
id INT NOT NULL AUTO_INCREMENT ,
name VARCHAR(30) NOT NULL ,
country VARCHAR(30) NOT NULL ,
year YEAR NOT NULL ,
genre VARCHAR(30) NOT NULL ,
PRIMARY KEY (id)) ENGINE = InnoDB;

ALTER TABLE session 
ADD FOREIGN KEY (movie_id) 
REFERENCES movie(id) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO movie 
(name, country, year, genre) VALUES
('Мавританець', 'США', '2021', 'драма'),
('Дрібниці', 'США', '2021', 'трилер'),
('Хоббіт: Битва п\'яти воїнств', 'Нова Зеландія', '2014', 'фентезі'),
('Потойбіччя', 'Швеція', '2020', 'жахи'),
('Аферистка', 'Великобританія', '2021', 'детектив'),
('День розплати', 'США', '2021', 'трилер')
