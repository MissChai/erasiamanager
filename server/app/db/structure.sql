DROP TABLE if exists t_character;

CREATE TABLE t_character (
	char_id integer not null PRIMARY KEY auto_increment,
	char_name varchar(255) not null,
	char_points integer DEFAULT 0,
	char_color varchar(255) DEFAULT null
) engine = innodb character SET utf8 collate utf8_unicode_ci;