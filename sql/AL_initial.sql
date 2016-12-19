/*
 * This is the initial setup SQL file for the AuraLight World of Warcraft character manager
 *	website.
 *
 * THIS IS UNTESTED, FIRST DRAFT STATUS!
 *
 * @author Jason Dusterwald
 * @last_updated 2016-12-18
 */

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
	id_profession_type int not null,
	id_profession_tier int not null,
	primary key (id),
	foreign key (id_profession_type) references al_profession_type(id) on delete cascade,
	foreign key (id_profession_tier) references al_profession_tier(id)
);

/*
 * al_profession_type - Gathering, production
 */
 
drop table if exists al_profession_type;
 
create table al_profession_type (
	id int not null auto_increment,
	profession_type varchar(16) not null,
	primary key (id)
);
 
/*
 * al_profession_tier - Primary, secondary
 */
 
drop table if exists al_profession_tier;
 
create table al_profession_tier (
	id int not null auto_increment,
	profession_tier varchar(16) not null,
	primary key (id)
);

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
	set new.id = uuid()
;

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
	id_player_owner char(36) not null,
	primary key (id),
	foreign key (id_character_class) references al_class(id) on delete cascade,
	foreign key (id_character_faction) references al_faction(id) on delete cascade,
	foreign key (id_character_gender) references al_gender(id) on delete cascade,
	foreign key (id_character_race) references al_race(id) on delete cascade,
	foreign key (id_player_owner) references al_player(id) on delete cascade
);

create trigger before_insert_al_character
	before insert on al_character
	for each row
	set new.id = uuid()
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

/*
 * al_race_class - Valid race/class combinations
 */

drop table if exists al_race_class;

create table al_race_class (
	id int not null auto_increment,
	id_race int not null,
	id_class int not null,
	primary key (id).
	foreign key (id_race) references al_race(id) on delete cascade,
	foreign key (id_class) references al_class(id) on delete cascade
);

/*
 * al_character_professions - Professions used by specific characters
 */
 
drop table if exists al_character_professions;

create table al_character_professions (
	id char(36) not null,
	id_character char(36) not null,
	id_profession int not null,
	profession_skill_level int not null,
	primary key(id),
	foreign key (id_character) references al_character(id) on delete cascade,
	foreign key (id_profession) references al_profession(id) on delete cascade
);

create trigger before_insert_al_character_professions (
	before insert on al_character_professions
	for each row
	set new.id = uuid()
);

/*
 * al_objective
 */
 
-- TODO: Finish this table, not fleshed out.
 
drop table if exists al_objective;
 
create table al_objective (
	id char(36) not null,
	id_objective_scope int not null,
	primary key (id),
	foreign key (id_objective_scope) references al_objective_scope(id) on delete cascade
);
 
create trigger before_insert_al_objective (
	before insert on al_objective
	for each row
	set new.id = uuid()
);
 
/*
 * al_objective_scope - Player or character - Is the player trying to get something done across
 *	multiple characters, or is a specific character trying to accomplish something?
 */

drop table if exists al_objective_scope;

create table al_objective_scope (
	id int not null auto_increment,
	objective_scope varchar(24) not null,
	primary key (id)
);