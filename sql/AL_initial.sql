/*
 * This is the initial setup SQL file for the AuraLight World of Warcraft character manager
 *	website.
 *
 * THIS IS UNTESTED, FIRST DRAFT STATUS!
 *
 * @author Jason Dusterwald
 * @last_updated 2016-12-17
 */

/*
 * al_character - Individual characters
 */

drop table if exists al_character;

create table al_character(
	id char(36) not null,
	character_name_game varchar(24) not null,
	character_name_last varchar(30),
	character_name_first varchar(30),
	character_name_middle_first varchar(30),
	character_name_middle_second varchar(30),
	id_character_class int not null,
	id_character_faction int not null,
	id_character_gender int not null,
	character_level int not null,
	id_character_race int not null,
	primary key (id),
	foreign key (id_character_class) references al_class(id) on delete cascade,
	foreign key (id_character_faction) references al_faction(id) on delete cascade,
	foreign key (id_character_gender) references al_gender(id) on delete cascade,
	foreign key (id_character_race) references al_race(id) on delete cascade
);

-- TODO: specialization(s), profession(s), and profession skill level(s)

create trigger before_insert_al_character
	before insert on al_character
	for each row
	set new.uuid = uuid()
;

/*
 * al_race - Races to which characters belong
 */
 
drop table if exists al_race;

create table al_race(
	id int not null auto_increment,
	race_name varchar(30) not null,
	race_reputation_name varchar(30) not null,
	primary key (id)
);

-- TODO: classes and factions available

/*
 * al_faction - Factions
 */

drop table if exists al_faction;

create table al_faction(
	id int not null auto_increment,
	faction_name varchar(24) not null,
	primary key (id)
);

/*
 *  al_gender - Gender
 */
 
drop table if exists al_gender;

create table al_gender(
	id int not null auto_increment,
	gender_name varchar(16) not null,
	primary key (id)
);

/*
 * al_class - Character class
 */
 
drop table if exists al_class;

create table al_class(
	id int not null auto_increment,
	class_name varchar(24) not null,
	primary key (id)
);

/*
 * al_specialization - Class specialization
 */

drop table if exists al_specialization;

create table al_specialization (
	id int not null auto_increment,
	specialization_name varchar(24) not null,
	parent_class int not null,
	id_specialization_role int not null,
	id_specialization_type int not null,
	primary key (id),
	foreign key (id_specialization_role) references al_specialization_role(id) on delete cascade
);

/*
 * al_specialization_role - Damage, tank, healer
 */
 
 drop table if exists al_specialization_role;
 
 create table al_specialization_role(
	id int not null auto_increment,
	name varchar(24) not null,
	primary key (id)
 );

/*
 * al_specialization_type - Melee, ranged
 */
 
 drop table if exists al_specialization_type;
 
 create table al_specialization_type(
	id int not null auto_increment,
	name varchar(24) not null,
	id_class int not null,
	primary key(id),
	foreign key (id_class) references al_class(id) on delete cascade
 );

/*
 * al_profession - Character professions/tradeskills
 */

drop table if exists al_profession;

create table al_profession (
	id int not null auto_increment,
	profession_name varchar(24) not null,
	profession_type int not null,
	profession_tier int not null,
	primary key (id)
);

/*
 * al_profession_type - Gathering, production
 */
 
/*
 * al_profession_tier - Primary, secondary
 */

/*
 * al_player - Player/user
 */

drop table if exists al_player;

create table al_player (
	id char(36) not null,
	player_username varchar(36) not null,
	player_email varchar(64) not null,
	player_name_first varchar(36),
	player_name_last varchar(36),
	player_name_middle varchar(36),
	primary key (id)
);

create trigger before_insert_al_player
	before insert on al_player
	for each row
	set new.uuid = uuid()
;

/*
 * al_race_faction - Valid race/faction combinations
 */

drop table if exists ai_race_faction;

create table al_race_faction (
	id int not null auto_increment,
	id_race int not null,
	id_faction int not null,
	primary key (id),
	foreign key (id_race) references al_race(id) on delete cascade,
	foreign key (id_faction) references al_faction(id) on delete cascade
);