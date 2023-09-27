START TRANSACTION;

CREATE DATABASE IF NOT EXISTS superbowl;

USE superbowl;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
	id_user int(11) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	first_name varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	password varchar(255),
	token varchar(255),
	token_date datetime,
	role varchar(255) DEFAULT 'user',
	PRIMARY KEY (id_user)
);

DROP TABLE IF EXISTS team;
CREATE TABLE IF NOT EXISTS team (
	id_team int(11) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	country varchar(255) NOT NULL,
	PRIMARY KEY (id_team)
);

DROP TABLE IF EXISTS player;
CREATE TABLE IF NOT EXISTS player(
	id_player int(11) NOT NULL,
	name varchar(255) NOT NULL,
	first_name varchar(255) NOT NULL,
	id_team int(11) NOT NULL,
	FOREIGN KEY (id_team) REFERENCES team(id_team)
);

DROP TABLE IF EXISTS game;
CREATE TABLE IF NOT EXISTS game(
	id_game int(11) NOT NULL AUTO_INCREMENT,
	start_time datetime NOT NULL,
	end_time datetime,
	id_team1 int(11) NOT NULL,
	id_team2 int(11) NOT NULL,
	odds_1 float,
	odds_2 float,
	score_1 TINYINT,
	score_2 TINYINT,
	weather VARCHAR(255),
	PRIMARY KEY (id_game),
	FOREIGN KEY (id_team1) REFERENCES team(id_team),
	FOREIGN KEY (id_team2) REFERENCES team(id_team)
);

DROP TABLE IF EXISTS comment;
CREATE TABLE IF NOT EXISTS comment(
	id_game int(11) NOT NULL,
	text text NOT NULL,
	`time` TIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (id_game) REFERENCES game(id_game)
);

DROP TABLE IF EXISTS bet;
CREATE TABLE IF NOT EXISTS bet(
	id_bet int(11) NOT NULL AUTO_INCREMENT,
	id_user int(11) NOT NULL,
	id_game int(11) NOT NULL,
	id_team int(11) NOT NULL,
	amount int(11) NOT NULL,
	profits int(11),
	losses int(11),
	date datetime DEFAULT CURRENT_TIMESTAMP(),
	PRIMARY KEY (id_bet),
	FOREIGN KEY (id_user) REFERENCES user(id_user),	
	FOREIGN KEY (id_game) REFERENCES game(id_game),
	FOREIGN KEY (id_team) REFERENCES team(id_team)
);

INSERT INTO user (name, first_name, email, password, role) VALUES
('Pierre', 'Jean', 'jeanpierre@mail.fr', '$2y$10$YTpLhZXyOLPq//8ADnOzvepQEqLhKKO40bCus0O2nIcRU7Jolh9gK', DEFAULT),
('Jean', 'Pierre', 'commentator@mail.fr', '$2y$10$zhx4uRVksoHG7Ss0i4eVZ.6F46WlEIDIslCJ/sAlA978KpChFoQfW', 'commentator'),
('Super', 'Bowl', 'admin@mail.fr', '$2y$10$B4iXGIKnQhH6Ruwhz4Y47OnKeRnbZtOQmzO1SSrdOLfy/13FUItHu', 'admin');

INSERT INTO team (id_team, name, country) VALUES
(1, 'Lions de Détroit', 'Détroit (Michigan)'),
(2, 'Bears de Chicago', 'Chicago (Illinois)'),
(3, 'Eagles de Philadelphie', 'Philadelphie (Pennsylvanie)'),
(4, 'Chiefs de Kansas City', 'Kansas City (Missouri)');

INSERT INTO player (id_player, first_name, name, id_team) VALUES
(26, 'Jahmyr', 'Gibbs', 1),
(16, 'Jared ', 'Goff', 1),
(5, 'David', 'Montgomery', 1),
(87, 'Sam', 'LaPorta', 1),
(1, 'Trevor', 'Siemian', 2),
(21, 'Darrynton ', 'Evans', 2),
(8, 'N\'Keal', 'Harry', 2),
(84, 'Ryan', 'Griffin', 2),
(1, 'Jalen', 'Hurts', 3),
(8, 'Kenneth', 'Gainwell', 3),
(6, 'DeVonta', 'Smith', 3),
(88, 'Dallas', 'Goedert', 3),
(4, 'Chad', 'Henne', 4),
(1, 'Jerick', 'McKinnon', 4),
(9, 'JuJu', 'Smith-Schuster', 4),
(83, 'Noah', 'Gray', 4);

INSERT INTO game (start_time, end_time, id_team1, id_team2, odds_1, odds_2, score_1, score_2, weather) VALUES 
('2023-02-12 18:30', '2023-02-12 19:30', 3, 4, 1.70, 2.05, 35, 38, 'nuageux'),
(NOW(), NULL, 1, 4, 2.30, 1.80, 40, 20, 'ensoleillé'),
(NOW() + INTERVAL 1 DAY, NULL, 1, 2, 1.50, 2, 40, 20, 'averses'),
(NOW() + INTERVAL 2 DAY, NULL, 2, 4, 1.20, 3, 28, 37, 'orage');

INSERT INTO comment (id_game, text) VALUES
(1, 'Get Ready for the Super Bowl!'),
(1, 'Super Bowl halftime show.'),
(1, 'Touchdown by Jaylen Hurts.'),
(2, 'Get Ready for the Super Bowl!'),
(2, 'Super Bowl halftime show.');

INSERT INTO bet (id_game, id_user, id_team, amount, profits, losses, date) VALUES
(1, 1, 3, 50, 35, 0, '2023-02-10 15:30'),
(2, 1, 4, 20, 0, 0, NOW() - INTERVAL 1 DAY),
(3, 1, 1, 100, 0, 0, NOW());

COMMIT;